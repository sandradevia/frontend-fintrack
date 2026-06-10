<?php

namespace App\Http\Controllers;

use App\Models\Dapur;
use App\Models\PenerimaanBarang;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class BapSisadanaController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'User tidak ditemukan');
        }

        $dapur = Dapur::findOrFail($user->dapur_id);

        // Periode dari filter atau default bulan berjalan
        $periodeAwal = $request->get(
            'periode_awal',
            Carbon::now()->startOfMonth()->format('Y-m-d')
        );

        $periodeAkhir = $request->get(
            'periode_akhir',
            Carbon::now()->endOfMonth()->format('Y-m-d')
        );

        // Total realisasi bahan baku
        $realisasi = PenerimaanBarang::with('barang')
            ->whereBetween('tanggal_masuk', [$periodeAwal, $periodeAkhir])
            ->whereHas('barang', function ($query) use ($dapur) {
                $query->where('dapur_id', $dapur->id);
            })
            ->get()
            ->sum(function ($item) {
                return $item->jumlah * $item->harga_beli;
            });

        $anggaran = 0;

        $totalSisa = $anggaran - $realisasi;

        return view('admin.bap-sisadana.index', [
            'title' => 'BAP Sisa Dana',
            'dapur' => $dapur,

            'periodeAwal' => $periodeAwal,
            'periodeAkhir' => $periodeAkhir,

            'totalRealisasi' => $realisasi,
            'totalSisa' => $totalSisa,
        ]);
    }

    public function exportPdf(Request $request)
    {
        $user = Auth::user();

        $dapur = Dapur::findOrFail($user->dapur_id);

        $periodeAwal = $request->get(
            'periode_awal',
            Carbon::now()->startOfMonth()->format('Y-m-d')
        );

        $periodeAkhir = $request->get(
            'periode_akhir',
            Carbon::now()->endOfMonth()->format('Y-m-d')
        );

        $totalSisa = $request->get('total_sisa', 0);

        $pdf = Pdf::loadView('admin.bap-sisadana.cetak', [
            'dapur' => $dapur,
            'periodeAwal' => $periodeAwal,
            'periodeAkhir' => $periodeAkhir,
            'totalSisa' => $totalSisa,
        ]);

        return $pdf
            ->setPaper('A4', 'portrait')
            ->download('BAP-Sisa-Dana.pdf');
    }

    public function exportWord(Request $request)
    {
        $user = Auth::user();

        $dapur = Dapur::findOrFail($user->dapur_id);

        $periodeAwal = $request->get(
            'periode_awal',
            Carbon::now()->startOfMonth()->format('Y-m-d')
        );

        $periodeAkhir = $request->get(
            'periode_akhir',
            Carbon::now()->endOfMonth()->format('Y-m-d')
        );

        $totalSisa = $request->get('total_sisa', 0);

        $html = view('admin.bap-sisadana.cetak', [
            'dapur' => $dapur,
            'periodeAwal' => $periodeAwal,
            'periodeAkhir' => $periodeAkhir,
            'totalSisa' => $totalSisa,
        ])->render();

        return response($html)
            ->header(
                'Content-Type',
                'application/msword'
            )
            ->header(
                'Content-Disposition',
                'attachment; filename="BAP-Sisa-Dana.doc"'
            );
    }
}