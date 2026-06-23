<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Dapur;
use App\Models\PenerimaanBarang;
use App\Models\Barang;
use App\Models\StokBarang;
use App\Models\Notification;

class PenerimaanBarangController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user || !$user->dapur) {
            abort(403, 'User belum memiliki dapur');
        }

        $dapur = $user->dapur;

        // Data penerimaan untuk dropdown & tabel
        $items = PenerimaanBarang::with('barang')
            ->whereHas('barang', fn($q) => $q->where('dapur_id', $dapur->id))
            ->latest()
            ->get();

        $barang = Barang::where('dapur_id', $dapur->id)
            ->orderBy('nama_barang')
            ->get();

        $periodeAwal = now()->startOfMonth()->format('d F Y');
        $periodeAkhir = now()->format('d F Y');

        $hal = PenerimaanBarang::paginate(10);

        return view('admin.penerimaan-barang.index', [
            'title'        => 'Penerimaan Barang',
            'user'         => $user,
            'items'        => $items,
            'barang'       => $barang,
            'dapur'        => $dapur,
            'periodeAwal'  => $periodeAwal,
            'periodeAkhir' => $periodeAkhir,
            'hal'          => $hal,
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user || !$user->dapur) {
            return response()->json([
                'status'  => 'error',
                'message' => 'User belum memiliki dapur'
            ], 403);
        }

        $dapur = $user->dapur;

        $request->validate([
            'nama_barang'   => 'required|string',
            'satuan'        => 'required|string',
            'jumlah'        => 'required|numeric|min:1',
            'harga_beli'    => 'required|numeric|min:0',
            'tanggal_masuk' => 'required|date',
            'supplier'      => 'nullable|string',
            'gambar'        => 'nullable|image|max:2048',
            'status'        => 'nullable|in:pending,disetujui,ditolak',
        ]);

        DB::beginTransaction();

        try {
            // 1️⃣ Simpan / ambil barang
            $barang = Barang::firstOrCreate(
                [
                    'nama_barang' => $request->nama_barang,
                    'dapur_id'    => $dapur->id,
                ],
                [
                    'satuan'   => $request->satuan,
                    'supplier' => $request->supplier ?? '-',
                ]
            );

            // 2️⃣ Simpan penerimaan
            $penerimaan = PenerimaanBarang::create([
                'barang_id'     => $barang->id,
                'tanggal_masuk' => $request->tanggal_masuk,
                'jumlah'        => $request->jumlah,
                'harga_beli'    => $request->harga_beli,
                'gambar'        => $request->hasFile('gambar') ? $request->file('gambar')->store('penerimaan_gambar', 'public') : null,
                'status'        => $request->status ?? 'pending',
            ]);

            // 3️⃣ Update stok barang
            $stok = StokBarang::firstOrCreate(
                [
                    'barang_id' => $barang->id,
                    'dapur_id'  => $dapur->id,
                ],
                ['stok' => 0]
            );

            $stok->increment('stok', $request->jumlah);

            // 4️⃣ Hitung total pengeluaran 12 hari terakhir
            $total12Hari = PenerimaanBarang::whereHas('barang', function ($q) use ($dapur) {
                $q->where('dapur_id', $dapur->id);
            })
            ->where('tanggal_masuk', '>=', now()->subDays(12))
            ->sum(DB::raw('jumlah * harga_beli'));

            $threshold = 5000000;

            if ($total12Hari >= $threshold) {
                Notification::create([
                    'dapur_id' => $dapur->id,
                    'title'    => 'Limit Pengeluaran',
                    'message'  => 'Pengeluaran dapur melebihi Rp '.number_format($threshold,0,',','.').' dalam 12 hari',
                    'type'     => 'warning',
                    'is_read'  => false,
                ]);

                Log::info("🔔 Notifikasi dibuat. Total 12 hari: ".$total12Hari);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'item'   => $penerimaan->load('barang'),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("ERROR store PenerimaanBarang: ".$e->getMessage());

            return response()->json([
                'status'  => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function superIndex(Request $request)
{
    $user = Auth::user();
    if (!$user) abort(403, 'User tidak ditemukan');

    $dapurId = $request->dapur_id;
    $dapurList = Dapur::orderBy('nama_lembaga')->get();

    // 1. Buat Query Utama (Gunakan satu variabel saja)
    $query = PenerimaanBarang::with('barang')
        ->when($dapurId, function ($q) use ($dapurId) {
            $q->whereHas('barang', function ($q2) use ($dapurId) {
                $q2->where('dapur_id', $dapurId);
            });
        })
        ->latest();

    // 2. Lakukan Paginasi (Hasilnya adalah Paginator)
    $hal = $query->paginate(20);

    // 3. Dropdown Barang tetap menggunakan get()
    $barang = Barang::when($dapurId, function ($q) use ($dapurId) {
            $q->where('dapur_id', $dapurId);
        })
        ->orderBy('nama_barang')
        ->get();

    return view('super.penerimaan-barang.index', [
        'title'        => 'Penerimaan Barang',
        'user'         => $user,
        'dapurList'    => $dapurList,
        'selectedDapur'=> $dapurId,
        'items'        => $hal, // Gunakan hasil paginate untuk $items
        'barang'       => $barang,
        'periodeAwal'  => now()->startOfMonth()->format('d F Y'),
        'periodeAkhir' => now()->format('d F Y'),
        'hal'          => $hal, 
    ]);
}

    public function edit($id)
    {
        $user = Auth::user();
        $dapur = $user->dapur;

        $item = PenerimaanBarang::whereHas('barang', fn($q) => $q->where('dapur_id', $dapur->id))
            ->with('barang')
            ->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'item'   => $item,
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $dapur = $user->dapur;

        $request->validate([
            'jumlah'        => 'required|numeric|min:1',
            'harga_beli'    => 'required|numeric|min:0',
            'tanggal_masuk' => 'required|date',
            'supplier'      => 'nullable|string',
            'gambar'        => 'nullable|image|max:2048',
            'status'        => 'nullable|in:pending,disetujui,ditolak',
        ]);

        $item = PenerimaanBarang::whereHas('barang', fn($q) => $q->where('dapur_id', $dapur->id))
            ->findOrFail($id);

        $updateData = $request->only(['jumlah', 'harga_beli', 'tanggal_masuk', 'status']);

        // Logika update gambar baru jika diunggah
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada di storage public sebelum diganti
            if ($item->gambar && Storage::disk('public')->exists($item->gambar)) {
                Storage::disk('public')->delete($item->gambar);
            }

            $updateData['gambar'] = $request->file('gambar')->store('penerimaan_gambar', 'public');
        }

        $item->update($updateData);

        return response()->json([
            'status' => 'success',
            'item'   => $item->load('barang'),
        ]);
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $dapur = $user->dapur;

        $item = PenerimaanBarang::whereHas('barang', fn($q) => $q->where('dapur_id', $dapur->id))
            ->findOrFail($id);

        // Hapus file fisik gambar saat row dihapus
        if ($item->gambar && Storage::disk('public')->exists($item->gambar)) {
            Storage::disk('public')->delete($item->gambar);
        }

        $item->delete();

        return response()->json([
            'status' => 'success',
        ]);
    }
}