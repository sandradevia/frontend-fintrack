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

        if (!$user) {
            abort(403, 'User tidak ditemukan');
        }

        $barang = Barang::with('stokAwal')->where('dapur_id', $user->dapur_id)->get();

        return view('admin.input-barang.index', [
            'title' => 'Input Barang',
            'user' => $user,
            'barang' => $barang,
        ]);
    }

    // ================= STORE =================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'satuan'      => 'required|string|max:20',
            'supplier'    => 'required|string|max:255',
            'stok'        => 'required|numeric|min:0',
        ]);

        $dapurId = Auth::user()->dapur_id;

        // 1. SIMPAN BARANG
        $barang = Barang::create([
            'nama_barang' => $validated['nama_barang'],
            'satuan'      => $validated['satuan'],
            'supplier'    => $request->supplier,
            'dapur_id'    => $dapurId,
        ]);

        // 2. SIMPAN STOK AWAL
        StokAwal::create([
            'barang_id' => $barang->id,
            'dapur_id'  => $dapurId,
            'jumlah'    => $validated['stok'],
        ]);

        return redirect()->back()->with('success', 'Barang berhasil ditambahkan');
    }

    // ================= DELETE =================
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);

        $user = Auth::user();

        if ((int)$barang->dapur_id !== (int)$user->dapur_id) {
            abort(403, 'Tidak bisa menghapus barang ini');
        }

        $barang->delete();

        return back()->with('success', 'Barang berhasil dihapus');
    }

    // ================= UPDATE =================
        public function update(Request $request, $id)
{
    try {
        $barang = Barang::findOrFail($id);

        $request->validate([
            'nama_barang' => 'required',
            'satuan' => 'required',
            'stok' => 'required|numeric',
        ]);

        $barang->update([
            'nama_barang' => $request->nama_barang,
            'satuan' => $request->satuan,
        ]);

        StokAwal::updateOrCreate(
            ['barang_id' => $barang->id],
            ['jumlah' => $request->stok]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil update'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
}
}