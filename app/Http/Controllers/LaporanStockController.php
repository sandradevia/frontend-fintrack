<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Barang;
use App\Models\StokBarang;
use App\Models\PenerimaanBarang;
use App\Models\PengeluaranBarang;
use App\Models\Dapur;
use App\Exports\LaporanStokExport;
use Illuminate\Pagination\LengthAwarePaginator;
use Maatwebsite\Excel\Facades\Excel;

class LaporanStockController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'User tidak ditemukan');
        }

        $items = Barang::with([
            'stok' => function ($q) use ($user) {
                $q->where('dapur_id', $user->dapur_id);
            },
            'penerimaan',
            'pengeluaran'
        ])
        ->where('dapur_id', $user->dapur_id)
        ->get()
        ->map(function ($barang) {

            $stok = optional($barang->stok?->first())->stok ?? 0;

            $masuk = $barang->penerimaan->sum('jumlah');
            $keluar = $barang->pengeluaran->sum('jumlah');

            return [
                'nama_barang' => $barang->nama_barang,
                'satuan' => $barang->satuan,
                'saldo_awal' => ($stok + $keluar) - $masuk, // estimasi awal
                'masuk' => $masuk,
                'keluar' => $keluar,
                'saldo_akhir' => $stok,
                'harga_beli' => $barang->penerimaan->last()->harga_beli ?? 0,
                'jumlah_nilai' => $stok * ($barang->penerimaan->last()->harga_beli ?? 0),
            ];
        });

        $dapur = $user->dapur;
        $periodeAwal = now()->startOfMonth()->format('d F Y');
        $periodeAkhir = now()->format('d F Y');

        return view('admin.laporan-stock.index', [
            'title' => 'Laporan Stock',
            'user' => $user,
            'items' => $items,
            'dapur' => $dapur,
            'periodeAwal' => $periodeAwal,
            'periodeAkhir' => $periodeAkhir,
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

        $collection = Barang::query()
            ->when($dapurId, function ($q) use ($dapurId) {
                $q->where('dapur_id', $dapurId);
            })
            ->with([
                'dapur',
                'stok' => function ($q) use ($dapurId) {
                    if ($dapurId) {
                        $q->where('dapur_id', $dapurId);
                    }
                },
                'penerimaan',
                'pengeluaran'
            ])
            ->get()
            ->map(function ($barang) {

                $stok = optional($barang->stok?->first())->stok ?? 0;

                $masuk = $barang->penerimaan->sum('jumlah');
                $keluar = $barang->pengeluaran->sum('jumlah');

                $hargaBeli = $barang->penerimaan->last()->harga_beli ?? 0;

                return [
                    'nama_dapur' => $barang->dapur->nama_lembaga ?? '-',
                    'nama_barang' => $barang->nama_barang,
                    'satuan' => $barang->satuan,

                    'saldo_awal' => ($stok + $keluar) - $masuk,
                    'masuk' => $masuk,
                    'keluar' => $keluar,
                    'saldo_akhir' => $stok,

                    'harga_beli' => $hargaBeli,
                    'jumlah_nilai' => $stok * $hargaBeli,
                ];
            });

        // PAGINATION
        $perPage = 20;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $currentItems = $collection
            ->slice(($currentPage - 1) * $perPage, $perPage)
            ->values();

        $items = new LengthAwarePaginator(
            $currentItems,
            $collection->count(),
            $perPage,
            $currentPage,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );

        return view('super.laporan-stock.index', [
            'title' => 'Laporan Stock',
            'user' => $user,

            'items' => $items,

            'dapurList' => $dapurList,
            'selectedDapur' => $dapurId,

            'periodeAwal' => now()->startOfMonth()->format('d F Y'),
            'periodeAkhir' => now()->format('d F Y'),
        ]);

        
    }

    private function getDataLaporanStok($periodeAwal = null, $periodeAkhir = null)
    {
        $user = Auth::user();

        return Barang::with([
            'stok' => function ($q) use ($user) {
                $q->where('dapur_id', $user->dapur_id);
            },
            'penerimaan',
            'pengeluaran'
        ])
        ->where('dapur_id', $user->dapur_id)
        ->get()
        ->map(function ($barang) {

            $stok = optional($barang->stok?->first())->stok ?? 0;

            $masuk = $barang->penerimaan->sum('jumlah');
            $keluar = $barang->pengeluaran->sum('jumlah');

            return [
                'nama_barang' => $barang->nama_barang,
                'satuan' => $barang->satuan,
                'saldo_awal' => ($stok + $keluar) - $masuk,
                'masuk' => $masuk,
                'keluar' => $keluar,
                'saldo_akhir' => $stok,
                'harga_beli' => $barang->penerimaan->last()->harga_beli ?? 0,
                'jumlah_nilai' => $stok * ($barang->penerimaan->last()->harga_beli ?? 0),
            ];
        });
    }    

    public function exportStok(Request $request)
    {
        $periodeAwal = $request->periode_awal;
        $periodeAkhir = $request->periode_akhir;

        // ambil data yang sama seperti laporan
        $items = $this->getDataLaporanStok($periodeAwal, $periodeAkhir);

        return Excel::download(
            new LaporanStokExport($items),
            'laporan_stok_barang.xlsx'
        );
    }
}