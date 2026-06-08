<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Dapur;
use App\Models\Periode;
use App\Models\Transaksi;
use Carbon\Carbon;
use App\Exports\BpOperasionalExport;
use Maatwebsite\Excel\Facades\Excel;

class BpOperasionalController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'User tidak ditemukan');
        }

        $dapur = Dapur::find($user->dapur_id);

        $periode = Periode::where('dapur_id', $user->dapur_id)
            ->where('is_active', true)
            ->first();

        $awalBulan = Carbon::now()->startOfMonth();

        /*
        |--------------------------------------------------------------------------
        | SALDO AWAL
        |--------------------------------------------------------------------------
        */
        $danaOperasionalSebelumnya = Transaksi::where('dapur_id', $user->dapur_id)
            ->where('tanggal', '<', $awalBulan)
            ->whereHas('akun', function ($q) {
                $q->where('nama_akun', 'Dana Operasional');
            })
            ->sum('debet');

        $pengeluaranOperasionalSebelumnya = Transaksi::where('dapur_id', $user->dapur_id)
            ->where('tanggal', '<', $awalBulan)
            ->whereHas('akun', function ($q) {
                $q->where('nama_akun', 'Biaya Operasional');
            })
            ->sum('kredit');

        $saldoAwal = $danaOperasionalSebelumnya - $pengeluaranOperasionalSebelumnya;

        /*
        |--------------------------------------------------------------------------
        | DANA MASUK BULAN INI
        |--------------------------------------------------------------------------
        */
        $danaMasuk = Transaksi::where('dapur_id', $user->dapur_id)
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->whereHas('akun', function ($q) {
                $q->where('nama_akun', 'Dana Operasional');
            })
            ->sum('debet');

        /*
        |--------------------------------------------------------------------------
        | PENGELUARAN BULAN INI
        |--------------------------------------------------------------------------
        */
        $totalPengeluaran = Transaksi::where('dapur_id', $user->dapur_id)
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->whereHas('akun', function ($q) {
                $q->where('nama_akun', 'Biaya Operasional');
            })
            ->sum('kredit');

        /*
        |--------------------------------------------------------------------------
        | DATA TRANSAKSI
        |--------------------------------------------------------------------------
        */
        $transaksiRaw = Transaksi::with('akun')
            ->where('dapur_id', $user->dapur_id)
            ->whereHas('akun', function ($q) {
                $q->where('nama_akun', 'Dana Operasional')
                    ->orWhere('nama_akun', 'Biaya Operasional');
            })
            ->orderBy('tanggal')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | HITUNG SALDO BERJALAN
        |--------------------------------------------------------------------------
        */
        $saldoBerjalan = $saldoAwal;

        $transaksis = [];

        foreach ($transaksiRaw as $trx) {

            $debet = $trx->debet ?? 0;
            $kredit = $trx->kredit ?? 0;

            $saldoBerjalan += ($debet - $kredit);

            $transaksis[] = [
                'tanggal' => $trx->tanggal,
                'no_bukti' => $trx->no_bukti,
                'uraian' => $trx->uraian,
                'debet' => $debet,
                'kredit' => $kredit,
                'saldo' => $saldoBerjalan,
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | SALDO AKHIR
        |--------------------------------------------------------------------------
        */
        $saldoAkhir = $saldoBerjalan;

        return view('admin.bp-operasional.index', [
            'title' => 'Buku Pembantu Dana Operasional',
            'user' => $user,
            'dapur' => $dapur,
            'periode' => $periode,

            'saldoAwal' => $saldoAwal,
            'danaMasuk' => $danaMasuk,
            'totalPengeluaran' => $totalPengeluaran,
            'saldoAkhir' => $saldoAkhir,

            'transaksis' => $transaksis,
        ]);
    }

    public function export()
    {
        return Excel::download(new BpOperasionalExport, 'buku_pembantu_dana_operasional.xlsx');
    }
}