<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Carbon\Carbon;

class BkuController extends Controller
{
    public function index(Request $request)
    {
        $bulan = (int) ($request->bulan ?? date('m'));
        $tahun = (int) ($request->tahun ?? date('Y'));

        // Awal periode
        $awalPeriode = Carbon::createFromDate($tahun, $bulan, 1);

        // ==========================
        // SALDO AWAL
        // ==========================
        $saldoAwal =
            Transaksi::where('tanggal', '<', $awalPeriode)
                ->sum('debet')
            -
            Transaksi::where('tanggal', '<', $awalPeriode)
                ->sum('kredit');

        // ==========================
        // TRANSAKSI PERIODE TERPILIH
        // ==========================
        $transaksi = Transaksi::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal')
            ->get();

        // ==========================
        // SALDO BERJALAN
        // ==========================
        $saldo = $saldoAwal;

        foreach ($transaksi as $item) {

            $saldo +=
                ($item->debet ?? 0)
                -
                ($item->kredit ?? 0);

            $item->saldo = $saldo;
        }

        // ==========================
        // TOTAL
        // ==========================
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

    public function exportExcel()
    {
        $transaksi = Transaksi::orderBy('tanggal', 'asc')->get();

        return response()->streamDownload(function () use ($transaksi) {

    $file = fopen('php://output', 'w');

    fputcsv($file, ['Tanggal','No Bukti','Uraian','Debet','Kredit','Keterangan']);

    foreach ($transaksi as $t) {
        fputcsv($file, [
            $t->tanggal,
            $t->no_bukti,
            $t->uraian,
            $t->debet,
            $t->kredit,
            $t->keterangan
        ]);
    }

    fclose($file);

}, 'bku.csv'); // 🔥 INI YANG BENAR// bisa .csv juga
    }
}