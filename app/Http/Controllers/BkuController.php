<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Transaksi;
use Carbon\Carbon;
use App\Models\Dapur;
use App\Models\Akun;

class BkuController extends Controller
{
   public function index(Request $request)
{
    $user = Auth::user();
    $dapurId = $user->dapur_id;
    $bulan = (int) ($request->bulan ?? date('m'));
    $tahun = (int) ($request->tahun ?? date('Y'));
    $awalPeriode = Carbon::createFromDate($tahun, $bulan, 1);

    // SALDO AWAL (semua transaksi sebelum periode, filter dapur saja)
    $saldoAwalBku = Transaksi::where('dapur_id', $dapurId)
        ->where('tanggal', '<', $awalPeriode)
        ->sum(DB::raw('debet - kredit'));

    // TRANSAKSI PERIODE INI
    $transaksi = Transaksi::where('dapur_id', $dapurId)
        ->whereMonth('tanggal', $bulan)
        ->whereYear('tanggal', $tahun)
        ->orderBy('tanggal')
        ->orderBy('id')
        ->get();

    // SALDO BERJALAN
    $saldo = $saldoAwalBku;
    foreach ($transaksi as $item) {
        $mutasi = ($item->debet ?? 0) - ($item->kredit ?? 0);
        $saldo += $mutasi;
        $item->saldo = $saldo;
    }

    $totalDebet  = $transaksi->sum('debet');
    $totalKredit = $transaksi->sum('kredit');
    $saldoAkhir  = $saldo;

    return view('admin.bku.index', compact(
        'transaksi',
        'saldoAwalBku',
        'totalDebet',
        'totalKredit',
        'saldoAkhir',
        'bulan',
        'tahun'
    ));
}

    public function superIndex(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'User tidak ditemukan');
        }

        $bulan = (int) ($request->bulan ?? date('m'));
        $tahun = (int) ($request->tahun ?? date('Y'));
        $dapurId = $request->dapur_id;

        $awalPeriode = Carbon::createFromDate($tahun, $bulan, 1);

        // ==========================
        // BASE QUERY (ROLE BASED)
        // ==========================
        $baseQuery = Transaksi::query()
            ->where('tanggal', '<', $awalPeriode);

        $periodeQuery = Transaksi::query()
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun);

        // 🔒 USER BIASA: hanya dapurnya sendiri
        if ($user->role !== 'super_admin') {
            $baseQuery->where('dapur_id', $user->dapur_id);
            $periodeQuery->where('dapur_id', $user->dapur_id);
        }

        // 🔥 SUPER ADMIN: bisa filter dapur
        if ($user->role === 'super_admin' && $dapurId) {
            $baseQuery->where('dapur_id', $dapurId);
            $periodeQuery->where('dapur_id', $dapurId);
        }

        // ==========================
        // SALDO AWAL
        // ==========================
        $saldoAwal =
            $baseQuery->sum('debet')
            -
            $baseQuery->sum('kredit');

        // ==========================
        // TRANSAKSI PERIODE
        // ==========================
        $transaksi = $periodeQuery
            ->orderBy('tanggal')
            ->orderBy('id')
            ->get();

        // ==========================
        // SALDO BERJALAN
        // ==========================
        $saldo = $saldoAwal;

        foreach ($transaksi as $item) {
            $saldo += ($item->debet ?? 0) - ($item->kredit ?? 0);
            $item->saldo = $saldo;
        }

        // ==========================
        // TOTAL
        // ==========================
        $totalDebet = $transaksi->sum('debet');
        $totalKredit = $transaksi->sum('kredit');
        $saldoAkhir = $saldo;

        $dapurList = Dapur::orderBy('nama_lembaga')->get();

        return view('super.bku.index', compact(
            'transaksi',
            'saldoAwal',
            'totalDebet',
            'totalKredit',
            'saldoAkhir',
            'bulan',
            'tahun',
            'dapurList',
            'dapurId'
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