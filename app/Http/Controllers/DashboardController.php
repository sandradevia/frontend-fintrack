<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;
use App\Models\User;
use App\Models\Jurnal;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;

class DashboardController extends Controller
{
    public function admin()
{
    $user = Auth::user();

    if (!$user || !$user->hasRole(['admin', 'super_admin'])) {
        abort(403);
    }

    // =====================
    // TOTAL DASHBOARD
    // =====================
    $totalTransaksi = Transaksi::count();
    $totalKaryawan = User::count();

    $totalAnggaran = Jurnal::selectRaw('COALESCE(SUM(debit - kredit),0) as total')
        ->value('total');

    // =====================
    // STOK MASUK (HARIAN 12 HARI TERAKHIR)
    // =====================
    $stokMasuk = BarangMasuk::selectRaw('
            DATE(tanggal_masuk) as hari,
            SUM(jumlah) as total
        ')
        ->where('tanggal_masuk', '>=', now()->subDays(11))
        ->groupByRaw('DATE(tanggal_masuk)')
        ->orderBy('hari')
        ->pluck('total', 'hari');

    // =====================
    // STOK KELUAR (HARIAN 12 HARI TERAKHIR)
    // =====================
    $stokKeluar = BarangKeluar::selectRaw('
            DATE(tanggal_keluar) as hari,
            SUM(jumlah) as total
        ')
        ->where('tanggal_keluar', '>=', now()->subDays(11))
        ->groupByRaw('DATE(tanggal_keluar)')
        ->orderBy('hari')
        ->pluck('total', 'hari');

    // =====================
    // FORMAT 12 HARI (WAJIB SUPAYA RAPI)
    // =====================
    $hari = [];
    $dataMasuk = [];
    $dataKeluar = [];

    for ($i = 11; $i >= 0; $i--) {
        $date = now()->subDays($i)->format('Y-m-d');

        $hari[] = now()->subDays($i)->format('d M');

        $dataMasuk[] = $stokMasuk[$date] ?? 0;
        $dataKeluar[] = $stokKeluar[$date] ?? 0;
    }

    return view('pages.dashboard.admin', compact(
        'totalTransaksi',
        'totalKaryawan',
        'totalAnggaran',
        'hari',
        'dataMasuk',
        'dataKeluar'
    ));
}
}