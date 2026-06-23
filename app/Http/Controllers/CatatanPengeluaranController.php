<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;
use App\Models\Dapur;
use App\Models\Barang;
use Carbon\Carbon;
use App\Exports\CatatanPengeluaranExport;
use Maatwebsite\Excel\Facades\Excel;

class CatatanPengeluaranController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'User tidak ditemukan');
        }
        $dapur = $user->dapur;
        $periodeAwal = now()->startOfMonth()->format('d F Y');
        $periodeAkhir = now()->format('d F Y');

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

        $bahanBaku = Transaksi::where('dapur_id', $user->dapur_id)->whereHas('akun', function ($q) {
        $q->where('nama_akun', 'Biaya Bahan Baku');})->sum('kredit');

        $operasional = Transaksi::where('dapur_id', $user->dapur_id)
            ->whereHas('akun', function ($q) {
                $q->where('nama_akun', 'Biaya Operasional');
            })
            ->sum('kredit');

        $insentifFasilitas = Transaksi::where('dapur_id', $user->dapur_id)
            ->whereHas('akun', function ($q) {
                $q->where('nama_akun', 'Biaya Insentif Fasilitas');
            })
            ->sum('kredit');

        $totalPengeluaran =
            $bahanBaku +
            $operasional +
            $insentifFasilitas;

        $sisaDana = $totalDana - $totalPengeluaran;

        $transaksis = Transaksi::where('dapur_id', $user->dapur_id)
            ->with('akun')
            ->orderBy('tanggal', 'asc')
            ->get();


        return view('admin.catatan-pengeluaran.index', [
            'title' => 'Catatan Pengeluaran',
            'user' => $user,
            'dapur' => $dapur,
            'periodeAwal' => $periodeAwal,
            'periodeAkhir' => $periodeAkhir,
            'danaMasuk' => $danaMasuk,
            'sisaDana' => $sisaDana,
            'bahanBaku' => $bahanBaku,
            'operasional' => $operasional,
            'insentifFasilitas' => $insentifFasilitas,
            'totalPengeluaran' => $totalPengeluaran,
            'totalDana' => $totalDana,
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
        | BASE QUERY (FILTER DAPUR)
        |--------------------------------------------------------------------------
        */
        $query = Transaksi::query();

        if ($dapurId) {
            $query->where('dapur_id', $dapurId);
        }

        /*
        |--------------------------------------------------------------------------
        | SALDO / DANA MASUK
        |--------------------------------------------------------------------------
        */
        $sisaDanaSebelumnya =
            (clone $query)->where('tanggal', '<', $awalBulan)->sum('debet')
            -
            (clone $query)->where('tanggal', '<', $awalBulan)->sum('kredit');

        $danaMasuk = (clone $query)
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->sum('debet');

        /*
        |--------------------------------------------------------------------------
        | PENGELUARAN PER KATEGORI
        |--------------------------------------------------------------------------
        */
        $bahanBaku = (clone $query)
            ->whereHas('akun', function ($q) {
                $q->where('nama_akun', 'Biaya Bahan Baku');
            })
            ->sum('kredit');

        $operasional = (clone $query)
            ->whereHas('akun', function ($q) {
                $q->where('nama_akun', 'Biaya Operasional');
            })
            ->sum('kredit');

        $insentifFasilitas = (clone $query)
            ->whereHas('akun', function ($q) {
                $q->where('nama_akun', 'Biaya Insentif Fasilitas');
            })
            ->sum('kredit');

        /*
        |--------------------------------------------------------------------------
        | TOTAL & SISA DANA
        |--------------------------------------------------------------------------
        */
        $totalDana = $sisaDanaSebelumnya + $danaMasuk;

        $totalPengeluaran =
            $bahanBaku +
            $operasional +
            $insentifFasilitas;

        $sisaDana = $totalDana - $totalPengeluaran;

        /*
        |--------------------------------------------------------------------------
        | TRANSAKSI DETAIL
        |--------------------------------------------------------------------------
        */
        $transaksis = Transaksi::with('akun')
            ->when($dapurId, function ($q) use ($dapurId) {
                $q->where('dapur_id', $dapurId);
            })
            ->orderBy('tanggal', 'asc')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | PERIODE TEXT
        |--------------------------------------------------------------------------
        */
        $periodeAwal = now()->startOfMonth()->format('d F Y');
        $periodeAkhir = now()->format('d F Y');

        return view('super.catatan-pengeluaran.index', [
            'title' => 'Catatan Pengeluaran',
            'user' => $user,

            'dapurList' => $dapurList,
            'selectedDapur' => $dapurId,
            'dapur' => $dapur,

            'periodeAwal' => $periodeAwal,
            'periodeAkhir' => $periodeAkhir,

            'danaMasuk' => $danaMasuk,
            'sisaDana' => $sisaDana,

            'bahanBaku' => $bahanBaku,
            'operasional' => $operasional,
            'insentifFasilitas' => $insentifFasilitas,

            'totalPengeluaran' => $totalPengeluaran,
            'totalDana' => $totalDana,

            'transaksis' => $transaksis,
        ]);
    }

    public function export()
    {
        $user = Auth::user();

        $transaksis = Transaksi::where('dapur_id', $user->dapur_id)
            ->where('kredit', '>', 0)
            ->with('akun')
            ->orderBy('tanggal', 'asc')
            ->get();

        return Excel::download(
            new CatatanPengeluaranExport($transaksis),
            'catatan_pengeluaran.xlsx'
        );
    }
}
