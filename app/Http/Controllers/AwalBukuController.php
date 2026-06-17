<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Dapur;
use App\Models\Periode;
use App\Models\SaldoAwalBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AwalBukuController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $dapur = Dapur::find($user->dapur_id);

        if (!$dapur) {
            abort(404, "Data dapur tidak ditemukan.");
        }

        $periodeAktif = Periode::where('dapur_id', $dapur->id)
            ->where('is_active', true)
            ->first();

        $statusPeriode = 'aktif'; 
        $pesanPeriode = '';
        $today = now()->format('Y-m-d');

        if (!$periodeAktif) {
            $statusPeriode = 'tidak_ada';
            $pesanPeriode = 'Belum ada periode akuntansi yang aktif. Silakan buat periode baru terlebih dahulu.';
        } elseif ($today > $periodeAktif->tanggal_selesai) {
            $statusPeriode = 'kadaluwarsa';
            $pesanPeriode = 'Periode akuntansi saat ini sudah kadaluwarsa. Silakan lakukan tutup buku untuk memperbarui periode.';
        }

        $allAkun = [];
        if ($periodeAktif) {
            $allAkun = Akun::query()
                ->with(['saldoAwalBuku' => function ($q) use ($periodeAktif) {
                    $q->where('periode_id', $periodeAktif->id);
                }])
                ->withSum(['transaksi as total_debet' => function ($q) use ($dapur, $periodeAktif) {
                    $q->where('dapur_id', $dapur->id)
                      ->whereBetween('tanggal', [$periodeAktif->tanggal_mulai, $periodeAktif->tanggal_selesai]);
                }], 'debet')
                ->withSum(['transaksi as total_kredit' => function ($q) use ($dapur, $periodeAktif) {
                    $q->where('dapur_id', $dapur->id)
                      ->whereBetween('tanggal', [$periodeAktif->tanggal_mulai, $periodeAktif->tanggal_selesai]);
                }], 'kredit')
                ->orderBy('kode')
                ->get();
        }

        $formattedAkun = [];
        if (!empty($allAkun)) {
            foreach ($allAkun as $item) {
                $saldoAwalNominal = $item->saldoAwalBuku->first()->saldo_awal ?? 0;
                $debet = $item->total_debet ?? 0;
                $kredit = $item->total_kredit ?? 0;
                
                $saldoAkhirNominal = $saldoAwalNominal + ($debet - $kredit);
                $status = ($saldoAkhirNominal >= 0) ? 'Sesuai' : 'Tidak Sesuai';

                $formattedAkun[] = [
                    'id'              => $item->id,
                    'kode'            => $item->kode,
                    'nama_akun'       => $item->nama_akun,
                    'saldo_awal_raw'  => $saldoAwalNominal,
                    'saldo_akhir_raw' => $saldoAkhirNominal,
                    'status'          => $status,
                    'is_section'      => false,
                    'is_parent'       => (strlen($item->kode) <= 3),
                    'is_sub'          => (strlen($item->kode) > 3),
                ];
            }
        }

        return view('admin.awal-buku.saldo', [
            'title'          => 'Saldo Awal Buku',
            'dapur'          => $dapur,
            'periode'        => $periodeAktif, 
            'akun'           => $formattedAkun,
            'status_periode' => $statusPeriode,
            'pesan_periode'  => $pesanPeriode,
        ]);
    }

    public function updateSaldo(Request $request)
    {
        // JIKA REDIRECT NYASAR MENGGUNAKAN GET, AMANKAN LANGSUNG KE INDEX SALDO
        if ($request->isMethod('get')) {
            return redirect()->route('admin.awal-buku.saldo');
        }

        $request->validate([
            'akun_id'    => 'required|exists:akun,id',
            'saldo_awal' => 'required|numeric|min:0',
        ]);

        $user = Auth::user();
        $periodeAktif = Periode::where('dapur_id', $user->dapur_id)->where('is_active', true)->first();

        if (!$periodeAktif) {
            return redirect()->route('admin.awal-buku.saldo')->with('error', 'Gagal menyesuaikan saldo, tidak ada periode aktif.');
        }

        SaldoAwalBuku::updateOrCreate(
            [
                'periode_id' => $periodeAktif->id,
                'akun_id'    => $request->akun_id,
            ],
            [
                'saldo_awal' => $request->saldo_awal,
            ]
        );

        return redirect()->route('admin.awal-buku.saldo')->with('success', 'Saldo awal akun berhasil diperbarui!');
    }
}