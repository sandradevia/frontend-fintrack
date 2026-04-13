<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Barang;

class InputBarangController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $items = Barang::all();

        if (!$user) {
            abort(403, 'User tidak ditemukan');
        }

        return view('admin.input-barang.index', [
            'title' => 'Input Barang',
            'user' => $user,
            'items' => $items,
        ]);
    }

    public function store(Request $request)
    {
        // Validasi
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'satuan'      => 'required|string|max:20',
            'stok'  => 'required|numeric|min:0',
            'harga_beli'  => 'required|numeric|min:0',
        ]);

        $validated['dapur_id'] = Auth::user()->dapur_id;

        // Simpan ke database
        Barang::create([
        'nama' => $request->nama,
        'satuan' => $request->satuan,
        'stok' => $request->stok,
        'harga_beli' => $request->harga_beli,
        'dapur_id' => $validated['dapur_id'],
        ]);

        return redirect()->back()->with('success', 'Barang berhasil ditambahkan');
    }

    public function destroy(Barang $barang)
    {
        // Pastikan barang milik dapur user login
        if ($barang->dapur_id != Auth::user()->dapur_id) {
            abort(403, 'Tidak bisa menghapus barang ini');
        }

        $barang->delete();

        return redirect()->back()->with('success', 'Barang berhasil dihapus');
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'nama' => 'required',
            'satuan' => 'required',
            'stok' => 'required|numeric',
            'harga_beli' => 'required|numeric',
        ]);

        $barang->update($request->only('nama', 'satuan', 'stok', 'harga_beli'));

        return response()->json([
            'status' => 'success',
            'message' => 'Barang berhasil diperbarui'
        ]);
    }
}
