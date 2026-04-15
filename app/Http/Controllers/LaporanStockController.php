<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Barang;
use App\Models\StokBarang;
use App\Models\PenerimaanBarang;
use App\Models\PengeluaranBarang;

class LaporanStockController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'User tidak ditemukan');
        }

        $items = Barang::with([
            'stok' => function ($q) use ($user) {
                $q->where('dapur_id', $user->dapur_id);
            },
            'penerimaan',
            'pengeluaran'
        ])
        ->where('dapur_id', $user->dapur_id)
        ->get()
        ->map(function ($barang) {

            $stok = $barang->stok->first()?->stok ?? 0;

            $masuk = $barang->penerimaan->sum('jumlah');
            $keluar = $barang->pengeluaran->sum('jumlah');

            return [
                'nama_barang' => $barang->nama_barang,
                'satuan' => $barang->satuan,
                'saldo_awal' => ($stok + $keluar) - $masuk, // estimasi awal
                'masuk' => $masuk,
                'keluar' => $keluar,
                'saldo_akhir' => $stok,
                'harga_beli' => $barang->penerimaan->last()->harga_beli ?? 0,
                'jumlah_nilai' => $stok * ($barang->penerimaan->last()->harga_beli ?? 0),
            ];
        });

        return view('admin.laporan-stock.index', [
            'title' => 'Laporan Stock',
            'user' => $user,
            'items' => $items,
        ]);
    }
}