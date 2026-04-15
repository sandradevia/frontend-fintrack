<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\PenerimaanBarang;
use App\Models\Barang;
use App\Models\StokBarang;

class PenerimaanBarangController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'User tidak ditemukan');
        }

        // 🔥 FILTER PER DAPUR LOGIN
        $items = PenerimaanBarang::with('barang')
            ->whereHas('barang', function ($q) use ($user) {
                $q->where('dapur_id', $user->dapur_id);
            })
            ->latest()
            ->get();

        // hanya barang sesuai dapur login
        $barangs = Barang::where('dapur_id', $user->dapur_id)->get();

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
        'nama_barang' => 'required|string',
        'satuan' => 'required|string',
        'jumlah' => 'required|numeric|min:1',
        'harga_beli' => 'required|numeric|min:0',
        'tanggal_masuk' => 'required|date',
    ]);

    DB::beginTransaction();

    try {

        $user = Auth::user();

        // 1. barang
        $barang = Barang::firstOrCreate(
            [
                'nama_barang' => $request->nama_barang,
                'dapur_id' => $user->dapur_id
            ],
            [
                'satuan' => $request->satuan,
                'supplier' => $request->supplier ?? '-'
            ]
        );

        // 2. penerimaan
        $penerimaan = PenerimaanBarang::create([
            'barang_id' => $barang->id,
            'tanggal_masuk' => $request->tanggal_masuk,
            'jumlah' => $request->jumlah,
            'harga_beli' => $request->harga_beli,
        ]);

        // 3. stok
        $stok = StokBarang::firstOrCreate(
            [
                'barang_id' => $barang->id,
                'dapur_id' => $user->dapur_id,
            ],
            [
                'stok' => 0
            ]
        );

        $stok->stok += $request->jumlah;
        $stok->last_update = now();
        $stok->save();

        DB::commit();

        return response()->json([
            'status' => 'success',
            'item' => $penerimaan->load('barang') // 🔥 FIX PENTING
        ]);

    } catch (\Exception $e) {

        DB::rollBack();

        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
}

    public function edit($id)
    {
        $item = PenerimaanBarang::with('barang')->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'item' => $item
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:1',
            'harga_beli' => 'required|numeric|min:0',
            'tanggal_masuk' => 'required|date',
        ]);

        $item = PenerimaanBarang::findOrFail($id);

        $item->update([
            'tanggal_masuk' => $request->tanggal_masuk,
            'jumlah' => $request->jumlah,
            'harga_beli' => $request->harga_beli,
        ]);

        return response()->json([
            'status' => 'success',
            'item' => $item->load('barang')
        ]);
    }

    public function destroy($id)
    {
        $item = PenerimaanBarang::findOrFail($id);
        $item->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }
}