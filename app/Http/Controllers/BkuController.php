<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi; // pastikan model ini ada

class BkuController extends Controller
{
    public function index(Request $request)
    {
        // 🔷 Ambil periode (default bulan ini)
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        // 🔷 Saldo awal (sementara hardcode dulu)
        $saldoAwal = 1000000;

        // 🔷 Ambil data transaksi berdasarkan periode
        $transaksi = Transaksi::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal', 'asc')
            ->get();

        // 🔷 Hitung saldo berjalan
        $saldo = $saldoAwal;

        foreach ($transaksi as $item) {
            $saldo += ($item->debet ?? 0) - ($item->kredit ?? 0);
            $item->saldo = $saldo; // inject ke object
        }

        // 🔷 Hitung total
        $totalDebet = $transaksi->sum('debet');
        $totalKredit = $transaksi->sum('kredit');
        $saldoAkhir = $saldo;

        return view('admin.bku.index', compact(
            'transaksi',
            'saldoAwal',
            'totalDebet',
            'totalKredit',
            'saldoAkhir',
            'bulan',
            'tahun'
        ));
    }
}