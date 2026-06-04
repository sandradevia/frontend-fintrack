<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\DaftarNominatif;
use Carbon\Carbon;
use App\Models\KehadiranNominatif;
use App\Models\Anggota;

class DaftarNominatifController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $anggotas = Anggota::orderBy('nama')->get();

        $nominatifs = DaftarNominatif::with([
                'anggota',
                'kehadiranNominatif',
            ])
            ->where('dapur_id', $user->dapur_id)
            ->orderBy('tanggal', 'desc')
            ->get();

        $hariKerjaBerjalan = min(
            KehadiranNominatif::whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)
                ->distinct('tanggal')
                ->count('tanggal'),
            25
        );
        $bulan = Carbon::now()->translatedFormat('F');
        $tahun = Carbon::now()->year;
        $tanggalKerja = KehadiranNominatif::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->select('tanggal')
            ->distinct()
            ->orderBy('tanggal')
            ->pluck('tanggal');

        

        return view('admin.daftar-nominatif.index', [
            'title' => 'Daftar Nominatif',
            'user' => $user,
            'anggotas' => $anggotas,
            'nominatifs' => $nominatifs,
            'hariKerjaBerjalan'=>$hariKerjaBerjalan,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'tanggalKerja' => $tanggalKerja,
        ]);
    }
}