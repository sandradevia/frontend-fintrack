<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PenerimaanBarang;
use App\Models\PembelianBarang;
use App\Models\Barang;

class PenerimaanBarangController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $items = PenerimaanBarang::with('barang')->get();
        $barangs = Barang::all();

        if (!$user) {
            abort(403, 'User tidak ditemukan');
        }

        return view('admin.penerimaan-barang.index', [
            'title' => 'Penerimaan Barang',
            'user' => $user,
            'items' => $items,
            'barangs' => $barangs,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_masuk' => 'required|date',
            'supplier' => 'required|string',
            'barang_id' => 'required|exists:barang,id',
            'jumlah' => 'required|numeric|min:1',
            'harga_beli' => 'required|numeric|min:0',
        ]);

        $total = $request->jumlah * $request->harga_beli;

        $item = PenerimaanBarang::create([
            'tanggal_masuk' => $request->tanggal_terima,
            'supplier' => $request->supplier,
            'barang_id' => $request->barang_id,
            'jumlah' => $request->jumlah,
            'harga_beli' => $request->harga_beli,
            'total_harga' => $total,
        ]);

        $item->load('barang'); // load relasi untuk response ajax

        return response()->json([
            'status' => 'success',
            'item' => $item
        ]);
    }
}
