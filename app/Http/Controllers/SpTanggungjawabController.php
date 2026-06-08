<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Dapur;
use App\Models\Anggota;
use App\Models\Transaksi;
use Carbon\Carbon;

class SpTanggungjawabController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'User tidak ditemukan');
        }
        $dapur = Dapur::first();

        $awalBulan = Carbon::now()->startOfMonth();

        $sisaDanaSebelumnya =
            Transaksi::where('dapur_id', $user->dapur_id)
                ->where('tanggal', '<', $awalBulan)
                ->sum('debet')
            -
            Transaksi::where('dapur_id', $user->dapur_id)
                ->where('tanggal', '<', $awalBulan)
                ->sum('kredit');

        $danaMasuk = Transaksi::where('dapur_id', $user->dapur_id)
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->sum('debet');

        $totalPengeluaran = Transaksi::where('dapur_id', $user->dapur_id)
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->sum('kredit');

        $totalDana = $sisaDanaSebelumnya + $danaMasuk;

        $sisaDana = $totalDana - $totalPengeluaran;

        return view('admin.sp-tanggungjawab.index', [
            'title' => 'SP Tanggung Jawab',
            'user' => $user,
            'dapur' => $dapur,
            'sisaDanaSebelumnya' => $sisaDanaSebelumnya,
            'danaMasuk' => $danaMasuk,
            'totalPengeluaran' => $totalPengeluaran,
            'sisaDana' => $sisaDana,
        ]);
    }
}
