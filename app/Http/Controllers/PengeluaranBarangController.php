<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\PengeluaranBarang;
use App\Models\Dapur;
use App\Models\Barang;
use App\Models\Anggota;
use App\Models\StokBarang;

class PengeluaranBarangController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'User tidak ditemukan');
        }

        $dapur = $user->dapur;

        $periodeAwal = now()->startOfMonth()->format('d F Y');
        $periodeAkhir = now()->format('d F Y');

        return view('admin.pengeluaran-barang.index', [
            'title' => 'Pengeluaran Barang',
            'user' => $user,
            'periodeAwal' => $periodeAwal,
            'periodeAkhir' => $periodeAkhir,
            'dapur' => $dapur,

            'items' => PengeluaranBarang::with(['barang.stok', 'anggota'])
                ->latest()
                ->get(),

            'barang' => Barang::with(['stok' => function ($q) use ($user) {
                $q->where('dapur_id', $user->dapur_id);
            }])
            ->where('dapur_id', $user->dapur_id)
            ->get(),

            'anggota' => Anggota::where('dapur_id', $user->dapur_id)->get(),
        ]);
    }

    public function superIndex(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'User tidak ditemukan');
        }

        $dapurId = $request->dapur_id;

        $dapurList = Dapur::orderBy('nama_lembaga')->get();

        /*
        |--------------------------------------------------------------------------
        | BASE QUERY
        |--------------------------------------------------------------------------
        */
        $query = PengeluaranBarang::with(['barang.stok', 'anggota'])
            ->when($dapurId, function ($q) use ($dapurId) {
                $q->whereHas('barang', function ($q2) use ($dapurId) {
                    $q2->where('dapur_id', $dapurId);
                });
            })
            ->latest();

        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */
        $items = $query->paginate(20)->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | DROPDOWN BARANG (FILTER BY DAPUR)
        |--------------------------------------------------------------------------
        */
        $barang = Barang::when($dapurId, function ($q) use ($dapurId) {
                $q->where('dapur_id', $dapurId);
            })
            ->orderBy('nama_barang')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | ANGGOTA (FILTER BY DAPUR JUGA)
        |--------------------------------------------------------------------------
        */
        $anggota = Anggota::when($dapurId, function ($q) use ($dapurId) {
                $q->where('dapur_id', $dapurId);
            })
            ->orderBy('nama')
            ->get();

        return view('super.pengeluaran-barang.index', [
            'title'         => 'Pengeluaran Barang',
            'user'          => $user,

            'dapurList'     => $dapurList,
            'selectedDapur' => $dapurId,

            'periodeAwal'   => now()->startOfMonth()->format('d F Y'),
            'periodeAkhir'  => now()->format('d F Y'),

            'items'         => $items,
            'barang'        => $barang,
            'anggota'       => $anggota,
        ]);
    }

    // ================= CREATE =================
    public function store(Request $request)
    {
        Log::info('PENGELUARAN REQUEST', $request->all());

        $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'anggota_id' => 'required|exists:anggota,id',
            'tanggal_keluar' => 'required|date',
            'jumlah' => 'required|numeric|min:1',
        ]);

        DB::beginTransaction();

        try {
            $user = Auth::user();

            // 🔥 CEK STOK (WAJIB FILTER DAPUR)
            $stok = StokBarang::where('barang_id', $request->barang_id)
                ->where('dapur_id', $user->dapur_id)
                ->lockForUpdate()
                ->first();

            if (!$stok || $stok->stok < $request->jumlah) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Stok tidak cukup'
                ], 422);
            }

            // 🔥 KURANGI STOK (Baris last_update dihapus karena kolomnya tidak ada di DB)
            $stok->stok -= $request->jumlah;
            $stok->save();

            // 🔥 SIMPAN PENGELUARAN
            $item = PengeluaranBarang::create([
                'barang_id' => $request->barang_id,
                'anggota_id' => $request->anggota_id,
                'tanggal_keluar' => $request->tanggal_keluar,
                'jumlah' => $request->jumlah,
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'item' => $item->load(['barang.stok', 'anggota'])
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // ================= EDIT =================
    public function edit($id)
    {
        $item = PengeluaranBarang::with(['barang.stok', 'anggota'])
            ->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'item' => $item
        ]);
    }

    // ================= UPDATE =================
    public function update(Request $request, $id)
    {
        $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'anggota_id' => 'required|exists:anggota,id',
            'tanggal_keluar' => 'required|date',
            'jumlah' => 'required|numeric|min:1',
        ]);

        DB::beginTransaction();

        try {
            $user = Auth::user();
            $item = PengeluaranBarang::findOrFail($id);

            // 🔥 rollback stok lama
            $stokLama = StokBarang::where('barang_id', $item->barang_id)
                ->where('dapur_id', $user->dapur_id)
                ->first();

            if ($stokLama) {
                $stokLama->stok += $item->jumlah;
                $stokLama->save();
            }

            // 🔥 cek stok baru
            $stokBaru = StokBarang::where('barang_id', $request->barang_id)
                ->where('dapur_id', $user->dapur_id)
                ->first();

            if (!$stokBaru || $stokBaru->stok < $request->jumlah) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Stok tidak cukup'
                ], 422);
            }

            $stokBaru->stok -= $request->jumlah;
            $stokBaru->save();

            $item->update([
                'barang_id' => $request->barang_id,
                'anggota_id' => $request->anggota_id,
                'tanggal_keluar' => $request->tanggal_keluar,
                'jumlah' => $request->jumlah,
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'item' => $item->load(['barang.stok', 'anggota'])
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // ================= DELETE =================
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $user = Auth::user();
            $item = PengeluaranBarang::findOrFail($id);

            // 🔥 kembalikan stok
            $stok = StokBarang::where('barang_id', $item->barang_id)
                ->where('dapur_id', $user->dapur_id)
                ->first();

            if ($stok) {
                $stok->stok += $item->jumlah;
                $stok->save();
            }

            $item->delete();

            DB::commit();

            return response()->json([
                'status' => 'success'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // ================= STOK API =================
    public function getStok($barang_id)
    {
        $user = Auth::user();

        $stok = StokBarang::where('barang_id', $barang_id)
            ->where('dapur_id', $user->dapur_id)
            ->first();

        return response()->json([
            'status' => 'success',
            'stok' => $stok?->stok ?? 0
        ]);
    }
}