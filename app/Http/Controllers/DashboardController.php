<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Transaksi;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;

class DashboardController extends Controller
{
    public function admin()
    {
        $user = Auth::user();

        if (!$user || !$user->hasRole(['admin', 'super_admin'])) {
            abort(403, 'Anda tidak memiliki akses ke halaman admin.');
        }

        // // ========================
        // // 🔹 DATA KEUANGAN
        // // ========================
        // $chartKeuangan = Transaksi::select(
        //         DB::raw('MONTH(tanggal) as bulan'),
        //         DB::raw('SUM(pemasukan) as pemasukan'),
        //         DB::raw('SUM(pengeluaran) as pengeluaran')
        //     )
        //     ->groupBy('bulan')
        //     ->orderBy('bulan')
        //     ->get();

        // // ========================
        // // 🔹 DATA STOK
        // // ========================
        // $stokData = DB::table('barang_masuk')
        //     ->select(
        //         DB::raw('MONTH(tanggal) as bulan'),
        //         DB::raw('SUM(jumlah) as masuk'),
        //         DB::raw('0 as keluar')
        //     )
        //     ->groupBy('bulan')

        //     ->unionAll(
        //         DB::table('barang_keluar')
        //             ->select(
        //                 DB::raw('MONTH(tanggal) as bulan'),
        //                 DB::raw('0 as masuk'),
        //                 DB::raw('SUM(jumlah) as keluar')
        //             )
        //             ->groupBy('bulan')
        //     )
        //     ->get()
        //     ->groupBy('bulan')
        //     ->map(function ($items) {
        //         return [
        //             'bulan' => $items[0]->bulan,
        //             'masuk' => $items->sum('masuk'),
        //             'keluar' => $items->sum('keluar'),
        //         ];
        //     })
        //     ->values();

        // // ========================
        // // 🔹 TOTAL STOK
        // // ========================
        // $totalStok = BarangMasuk::sum('jumlah') - BarangKeluar::sum('jumlah');

        // // ========================
        // // 🔹 RETURN VIEW
        // // ========================
        return view('pages.dashboard.admin', [
            'title' => 'Dashboard Admin',
            // 'chartKeuangan' => $chartKeuangan,
            // 'stokData' => $stokData,
            // 'totalStok' => $totalStok,
        ]);
    }

    public function superAdmin()
    {
        $user = Auth::user();

        if (!$user || !$user->hasRole('super_admin')) {
            abort(403, 'Anda tidak memiliki akses ke halaman super admin.');
        }

        return view('pages.dashboard.super_admin', [
            'title' => 'Dashboard Super Admin',
        ]);
    }
}
