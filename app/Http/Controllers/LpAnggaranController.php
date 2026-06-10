<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Dapur;
use App\Models\PenerimaanBarang;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class LpAnggaranController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'User tidak ditemukan');
        }

        // Ambil dapur user
        $dapur = Dapur::findOrFail($user->dapur_id);

        // Periode
        $periodeAwal = $request->get(
            'periode_awal',
            Carbon::now()->startOfMonth()->format('Y-m-d')
        );

        $periodeAkhir = $request->get(
            'periode_akhir',
            Carbon::now()->endOfMonth()->format('Y-m-d')
        );

        /*
        |--------------------------------------------------------------------------
        | REALISASI BAHAN BAKU
        |--------------------------------------------------------------------------
        */

        $realisasiBahanBaku = PenerimaanBarang::with('barang')
            ->whereBetween('tanggal_masuk', [$periodeAwal, $periodeAkhir])
            ->whereHas('barang', function ($query) use ($dapur) {
                $query->where('dapur_id', $dapur->id);
            })
            ->get()
            ->sum(function ($item) {
                return $item->jumlah * $item->harga_beli;
            });

        /*
        |--------------------------------------------------------------------------
        | SEMENTARA BELUM ADA DATA OPERASIONAL & SEWA
        |--------------------------------------------------------------------------
        */

        $realisasiOperasional = 0;
        $realisasiSewa = 0;

        /*
        |--------------------------------------------------------------------------
        | ANGGARAN
        |--------------------------------------------------------------------------
        | Karena kolom anggaran belum ada di tabel dapur
        */

        $anggaranBahanBaku = 0;
        $anggaranOperasional = 0;
        $anggaranSewa = 0;

        /*
        |--------------------------------------------------------------------------
        | RINCIAN
        |--------------------------------------------------------------------------
        */

        $rincian = [
            [
                'label' => 'Bahan Baku',
                'diajukan' => $anggaranBahanBaku,
                'terealisasi' => $realisasiBahanBaku,
                'sisa' => $anggaranBahanBaku - $realisasiBahanBaku,
            ],
            [
                'label' => 'Operasional',
                'diajukan' => $anggaranOperasional,
                'terealisasi' => $realisasiOperasional,
                'sisa' => $anggaranOperasional - $realisasiOperasional,
            ],
            [
                'label' => 'Sewa',
                'diajukan' => $anggaranSewa,
                'terealisasi' => $realisasiSewa,
                'sisa' => $anggaranSewa - $realisasiSewa,
            ],
        ];

        $totalDiajukan = collect($rincian)->sum('diajukan');
        $totalTerealisasi = collect($rincian)->sum('terealisasi');
        $totalSisa = collect($rincian)->sum('sisa');

        return view('admin.lp-anggaran.index', [
            'title' => 'Laporan Penggunaan Anggaran',

            'user' => $user,
            'dapur' => $dapur,

            'periodeAwal' => Carbon::parse($periodeAwal)
                ->translatedFormat('d F Y'),

            'periodeAkhir' => Carbon::parse($periodeAkhir)
                ->translatedFormat('d F Y'),

            'periodeAwalRaw' => $periodeAwal,
            'periodeAkhirRaw' => $periodeAkhir,

            'rincian' => $rincian,

            'totalDiajukan' => $totalDiajukan,
            'totalTerealisasi' => $totalTerealisasi,
            'totalSisa' => $totalSisa,
        ]);
    }
    public function exportWord(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'User tidak ditemukan');
        }

        // Ambil dapur user
        $dapur = Dapur::findOrFail($user->dapur_id);

        // Periode
        $periodeAwal = $request->get(
            'periode_awal',
            Carbon::now()->startOfMonth()->format('Y-m-d')
        );

        $periodeAkhir = $request->get(
            'periode_akhir',
            Carbon::now()->endOfMonth()->format('Y-m-d')
        );

        /*
        |--------------------------------------------------------------------------
        | REALISASI BAHAN BAKU
        |--------------------------------------------------------------------------
        */

        $realisasiBahanBaku = PenerimaanBarang::with('barang')
            ->whereBetween('tanggal_masuk', [$periodeAwal, $periodeAkhir])
            ->whereHas('barang', function ($query) use ($dapur) {
                $query->where('dapur_id', $dapur->id);
            })
            ->get()
            ->sum(function ($item) {
                return $item->jumlah * $item->harga_beli;
            });

        /*
        |--------------------------------------------------------------------------
        | SEMENTARA BELUM ADA DATA OPERASIONAL & SEWA
        |--------------------------------------------------------------------------
        */

        $realisasiOperasional = 0;
        $realisasiSewa = 0;

        /*
        |--------------------------------------------------------------------------
        | ANGGARAN
        |--------------------------------------------------------------------------
        | Karena kolom anggaran belum ada di tabel dapur
        */

        $anggaranBahanBaku = 0;
        $anggaranOperasional = 0;
        $anggaranSewa = 0;

        /*
        |--------------------------------------------------------------------------
        | RINCIAN
        |--------------------------------------------------------------------------
        */

        $rincian = [
            [
                'label' => 'Bahan Baku',
                'diajukan' => $anggaranBahanBaku,
                'terealisasi' => $realisasiBahanBaku,
                'sisa' => $anggaranBahanBaku - $realisasiBahanBaku,
            ],
            [
                'label' => 'Operasional',
                'diajukan' => $anggaranOperasional,
                'terealisasi' => $realisasiOperasional,
                'sisa' => $anggaranOperasional - $realisasiOperasional,
            ],
            [
                'label' => 'Sewa',
                'diajukan' => $anggaranSewa,
                'terealisasi' => $realisasiSewa,
                'sisa' => $anggaranSewa - $realisasiSewa,
            ],
        ];

        $totalDiajukan = collect($rincian)->sum('diajukan');
        $totalTerealisasi = collect($rincian)->sum('terealisasi');
        $totalSisa = collect($rincian)->sum('sisa');
        $html = view('admin.lp-anggaran.word', [
            'dapur' => $dapur,
            'rincian' => $rincian,
            'totalDiajukan' => $totalDiajukan,
            'totalTerealisasi' => $totalTerealisasi,
            'totalSisa' => $totalSisa,

            'periodeAwal' => Carbon::parse($periodeAwal)
                ->translatedFormat('d F Y'),

            'periodeAkhir' => Carbon::parse($periodeAkhir)
                ->translatedFormat('d F Y'),

            'periodeAwalRaw' => $periodeAwal,
            'periodeAkhirRaw' => $periodeAkhir,
        ])->render();

        return response($html)
            ->header('Content-Type', 'application/msword')
            ->header(
                'Content-Disposition',
                'attachment; filename="laporan-anggaran.doc"'
            );
    }

    public function exportPdf(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'User tidak ditemukan');
        }

        // Ambil dapur user
        $dapur = Dapur::findOrFail($user->dapur_id);

        // Periode
        $periodeAwal = $request->get(
            'periode_awal',
            Carbon::now()->startOfMonth()->format('Y-m-d')
        );

        $periodeAkhir = $request->get(
            'periode_akhir',
            Carbon::now()->endOfMonth()->format('Y-m-d')
        );

        /*
        |--------------------------------------------------------------------------
        | REALISASI BAHAN BAKU
        |--------------------------------------------------------------------------
        */

        $realisasiBahanBaku = PenerimaanBarang::with('barang')
            ->whereBetween('tanggal_masuk', [$periodeAwal, $periodeAkhir])
            ->whereHas('barang', function ($query) use ($dapur) {
                $query->where('dapur_id', $dapur->id);
            })
            ->get()
            ->sum(function ($item) {
                return $item->jumlah * $item->harga_beli;
            });

        /*
        |--------------------------------------------------------------------------
        | SEMENTARA BELUM ADA DATA OPERASIONAL & SEWA
        |--------------------------------------------------------------------------
        */

        $realisasiOperasional = 0;
        $realisasiSewa = 0;

        /*
        |--------------------------------------------------------------------------
        | ANGGARAN
        |--------------------------------------------------------------------------
        | Karena kolom anggaran belum ada di tabel dapur
        */

        $anggaranBahanBaku = 0;
        $anggaranOperasional = 0;
        $anggaranSewa = 0;

        /*
        |--------------------------------------------------------------------------
        | RINCIAN
        |--------------------------------------------------------------------------
        */

        $rincian = [
            [
                'label' => 'Bahan Baku',
                'diajukan' => $anggaranBahanBaku,
                'terealisasi' => $realisasiBahanBaku,
                'sisa' => $anggaranBahanBaku - $realisasiBahanBaku,
            ],
            [
                'label' => 'Operasional',
                'diajukan' => $anggaranOperasional,
                'terealisasi' => $realisasiOperasional,
                'sisa' => $anggaranOperasional - $realisasiOperasional,
            ],
            [
                'label' => 'Sewa',
                'diajukan' => $anggaranSewa,
                'terealisasi' => $realisasiSewa,
                'sisa' => $anggaranSewa - $realisasiSewa,
            ],
        ];

        $totalDiajukan = collect($rincian)->sum('diajukan');
        $totalTerealisasi = collect($rincian)->sum('terealisasi');
        $totalSisa = collect($rincian)->sum('sisa');
        return Pdf::loadView('admin.lp-anggaran.pdf', [
            'dapur' => $dapur,
            'periodeAwal' => $periodeAwal,
            'periodeAkhir' => $periodeAkhir,
            'rincian' => $rincian,
            'totalDiajukan' => $totalDiajukan,
            'totalTerealisasi' => $totalTerealisasi,
            'totalSisa' => $totalSisa,
            
            'periodeAwal' => Carbon::parse($periodeAwal)
                ->translatedFormat('d F Y'),

            'periodeAkhir' => Carbon::parse($periodeAkhir)
                ->translatedFormat('d F Y'),

            'periodeAwalRaw' => $periodeAwal,
            'periodeAkhirRaw' => $periodeAkhir,
            
        ])->download('laporan-anggaran.pdf');
    }
}