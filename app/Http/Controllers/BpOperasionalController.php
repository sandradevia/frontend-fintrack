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

    public function superIndex(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'User tidak ditemukan');
        }

        $dapurId = $request->dapur_id;

        $dapurList = Dapur::orderBy('nama_lembaga')->get();

        $dapur = $dapurId
            ? Dapur::find($dapurId)
            : null;

        $awalBulan = Carbon::now()->startOfMonth();

        /*
        |--------------------------------------------------------------------------
        | BASE FILTER (SUPER ADMIN / FILTER DAPUR)
        |--------------------------------------------------------------------------
        */
        $baseQuery = Transaksi::where('tanggal', '<', $awalBulan);
        $periodeQuery = Transaksi::query();

        if ($dapurId) {
            $baseQuery->where('dapur_id', $dapurId);
            $periodeQuery->where('dapur_id', $dapurId);
        }

        /*
        |--------------------------------------------------------------------------
        | SALDO AWAL
        |--------------------------------------------------------------------------
        */
        $danaOperasionalSebelumnya = (clone $baseQuery)
            ->whereHas('akun', function ($q) {
                $q->where('nama_akun', 'Dana Operasional');
            })
            ->sum('debet');

        $pengeluaranOperasionalSebelumnya = (clone $baseQuery)
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
        $danaMasuk = (clone $periodeQuery)
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
        $totalPengeluaran = (clone $periodeQuery)
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
            ->when($dapurId, function ($q) use ($dapurId) {
                $q->where('dapur_id', $dapurId);
            })
            ->whereHas('akun', function ($q) {
                $q->whereIn('nama_akun', [
                    'Dana Operasional',
                    'Biaya Operasional'
                ]);
            })
            ->orderBy('tanggal')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | SALDO BERJALAN
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

        $saldoAkhir = $saldoBerjalan;

        return view('super.bp-operasional.index', [
            'title' => 'Buku Pembantu Dana Operasional',
            'user' => $user,
            'dapur' => $dapur,
            'dapurList' => $dapurList,
            'selectedDapur' => $dapurId,

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