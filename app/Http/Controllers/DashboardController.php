<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;
use App\Models\User;
use App\Models\Jurnal;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\Dapur;
use App\Models\Anggota;

class DashboardController extends Controller
{
    public function admin()
    {
        $user = Auth::user();

        if (!$user || !$this->userHasRole($user, ['admin', 'super_admin'])) {
            abort(403);
        }

        // Ambil dapur user login
        $dapur = $user->dapur;

        // =====================
        // TOTAL DASHBOARD
        // =====================
        $totalTransaksi = Transaksi::count();
        $totalKaryawan = User::count();

        $totalAnggaran = Jurnal::selectRaw('COALESCE(SUM(debit - kredit),0) as total')
            ->value('total');

        // =====================
        // STOK MASUK
        // =====================
        $stokMasuk = BarangMasuk::selectRaw("
                DATE(tanggal_masuk) as hari,
                SUM(jumlah) as total
            ")
            ->where('tanggal_masuk', '>=', now()->subDays(11))
            ->groupByRaw('DATE(tanggal_masuk)')
            ->orderBy('hari')
            ->pluck('total', 'hari');

        // =====================
        // STOK KELUAR
        // =====================
        $stokKeluar = BarangKeluar::selectRaw("
                DATE(tanggal_keluar) as hari,
                SUM(jumlah) as total
            ")
            ->where('tanggal_keluar', '>=', now()->subDays(11))
            ->groupByRaw('DATE(tanggal_keluar)')
            ->orderBy('hari')
            ->pluck('total', 'hari');

        // =====================
        // FORMAT DATA GRAFIK
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
            'dapur',
            'totalTransaksi',
            'totalKaryawan',
            'totalAnggaran',
            'hari',
            'dataMasuk',
            'dataKeluar'
        ));
    }

    private function userHasRole($user, $roles)
    {
        if (!$user) {
            return false;
        }

        if (method_exists($user, 'hasRole')) {
            return $user->hasRole($roles);
        }

        $role = $user->role ?? null;

        if (is_array($roles)) {
            return in_array($role, $roles, true);
        }

        return $role === $roles;
    }

    public function superAdmin()
    {
        $user = Auth::user();

        if (!$user || !$this->userHasRole($user, 'super_admin')) {
            abort(403);
        }

        // =====================
        // CARD STATISTIK
        // =====================
        $totalDapur = Dapur::count();
        $totalanggota = Anggota::count();
        $totalTransaksi = Transaksi::count();

        $totalPemasukan = Jurnal::sum('debit');
        $totalPengeluaran = Jurnal::sum('kredit');

        $saldo = $totalPemasukan - $totalPengeluaran;

        // =====================
        // GRAFIK 12 BULAN
        // =====================
        $bulan = [];
        $dataPemasukan = [];
        $dataPengeluaran = [];

        for ($i = 11; $i >= 0; $i--) {

            $tanggal = now()->subMonths($i);

            $bulan[] = $tanggal->format('M');

            $dataPemasukan[] = Jurnal::whereHas('transaksi', function ($query) use ($tanggal) {
                $query->whereYear('tanggal', $tanggal->year)
                    ->whereMonth('tanggal', $tanggal->month);
            })->sum('debit');

            $dataPengeluaran[] = Jurnal::whereHas('transaksi', function ($query) use ($tanggal) {
                $query->whereYear('tanggal', $tanggal->year)
                    ->whereMonth('tanggal', $tanggal->month);
            })->sum('kredit');
        }

        // =====================
        // TRANSAKSI TERBARU
        // =====================
        $transaksiTerbaru = Transaksi::latest()
            ->take(5)
            ->get();

        // =====================
        // USER TERBARU
        // =====================
        $userTerbaru = User::latest()
            ->take(5)
            ->get();

        return view('pages.dashboard.super_admin', compact(
            'totalDapur',
            'totalanggota',
            'totalTransaksi',
            'totalPemasukan',
            'totalPengeluaran',
            'saldo',
            'bulan',
            'dataPemasukan',
            'dataPengeluaran',
            'transaksiTerbaru',
            'userTerbaru'
        ));
    }
}