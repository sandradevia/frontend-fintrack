<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Barang;
use App\Models\StokAwal;

class InputBarangController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // ambil dapur dari relasi user -> dapur
        $dapur = $user->dapur;

        if (!$user || !$dapur) {
            abort(403, 'User belum terhubung ke dapur');
        }

        $barang = Barang::with('stokAwal')
            ->where('dapur_id', $dapur->id)
            ->latest()
            ->get();

        return view('admin.input-barang.index', [
            'title'  => 'Input Barang',
            'user'   => $user,
            'barang' => $barang,
        ]);
    }

    // ================= STORE =================
    public function store(Request $request)
    {
        $user = Auth::user();

        $dapur = $user->dapur;

        if (!$user || !$dapur) {
            abort(403, 'User tidak memiliki dapur');
        }

        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'satuan'      => 'required|string|max:20',
            'supplier'    => 'required|string|max:255',
            'stok'        => 'required|numeric|min:0',
        ]);

        // 1. SIMPAN BARANG
        $barang = Barang::create([
            'nama_barang' => $validated['nama_barang'],
            'satuan'      => $validated['satuan'],
            'supplier'    => $validated['supplier'],
            'dapur_id'    => $dapur->id,
        ]);

        // 2. SIMPAN STOK AWAL
        StokAwal::create([
            'barang_id' => $barang->id,
            'dapur_id'  => $dapur->id,
            'jumlah'    => $validated['stok'],
        ]);

        return redirect()
            ->back()
            ->with('success', 'Barang berhasil ditambahkan');
    }

    // ================= DELETE =================
    public function destroy($id)
    {
        $user = Auth::user();

        $dapur = $user->dapur;

        if (!$dapur) {
            abort(403, 'Dapur tidak ditemukan');
        }

        $barang = Barang::where('id', $id)
            ->where('dapur_id', $dapur->id)
            ->firstOrFail();

        // hapus stok awal dulu
        StokAwal::where('barang_id', $barang->id)->delete();

        $barang->delete();

        return back()->with('success', 'Barang berhasil dihapus');
    }

    // ================= UPDATE =================
    public function update(Request $request, $id)
    {
        try {

            $user = Auth::user();

            $dapur = $user->dapur;

            if (!$dapur) {
                abort(403, 'Dapur tidak ditemukan');
            }

            $barang = Barang::where('id', $id)
                ->where('dapur_id', $dapur->id)
                ->firstOrFail();

            $request->validate([
                'nama_barang' => 'required|string|max:255',
                'satuan'      => 'required|string|max:20',
                'stok'        => 'required|numeric|min:0',
            ]);

            // update barang
            $barang->update([
                'nama_barang' => $request->nama_barang,
                'satuan'      => $request->satuan,
            ]);

            // update stok awal
            StokAwal::updateOrCreate(
                [
                    'barang_id' => $barang->id,
                    'dapur_id'  => $dapur->id,
                ],
                [
                    'jumlah' => $request->stok,
                ]
            );

            return response()->json([
                'status'  => 'success',
                'message' => 'Berhasil update',
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}