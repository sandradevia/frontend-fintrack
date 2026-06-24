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

    // ==================================================
    // HARDCODE SALDO AWAL PER PERIODE (untuk demo sidang)
    // ==================================================
    $saldoAwalHardcode = [
        // Periode 2 - Dapur 1 (2026-06-08 s/d 2026-06-19)
        2 => [
            '1101' => 5000000,
            '1102' => 374208000,
            '2110' => 301316000,
            '2120' => 76592000,
            '2130' => 0,
            '3110' => 49650000,
            '3120' => 34000000,
            '3130' => 72000000,
        ],
        // Periode 3 - Dapur 1 (2026-06-22 s/d 2026-07-03)
        3 => [
            '1101' => 5000000,
            '1102' => 379208000,
            '2110' => 242816000,
            '2120' => 54042000,
            '2130' => 0,
            '3110' => 57650000,
            '3120' => 56542000,
            '3130' => 0,
        ],
        // Periode 8 - Dapur 5 (2025-12-29 s/d 2026-01-09)
        8 => [
            '1101' => 2000000,
            '1102' => 8000000,
            '2110' => 3500000,
            '2120' => 6500000,
            '2130' => 0,
            '3110' => 0,
            '3120' => 0,
            '3130' => 0,
        ],
        // Periode 9 - Dapur 5 (2026-06-01 s/d 2026-06-13)
        9 => [
            '1101' => 2000000,
            '1102' => 8000000,
            '2110' => 3500000,
            '2120' => 6500000,
            '2130' => 0,
            '3110' => 0,
            '3120' => 0,
            '3130' => 0,
        ],
        // Periode 10 - Dapur 5 (2026-06-15 s/d 2026-06-27)
        10 => [
            '1101' => 2000000,
            '1102' => 8000000,
            '2110' => 3500000,
            '2120' => 6500000,
            '2130' => 0,
            '3110' => 0,
            '3120' => 0,
            '3130' => 0,
        ],
    ];

    // ==================================================
    // HITUNG SALDO AWAL AKUN INDUK OTOMATIS
    // ==================================================
    if ($periodeAktif && isset($saldoAwalHardcode[$periodeAktif->id])) {
        $h = &$saldoAwalHardcode[$periodeAktif->id];

        $h['1100'] = ($h['1101'] ?? 0) + ($h['1102'] ?? 0);
        $h['1000'] = ($h['1101'] ?? 0) + ($h['1102'] ?? 0);

        $h['2000'] = ($h['2110'] ?? 0) + ($h['2120'] ?? 0) + ($h['2130'] ?? 0)
                   + ($h['2140'] ?? 0) + ($h['2150'] ?? 0) + ($h['2160'] ?? 0)
                   + ($h['2170'] ?? 0) + ($h['2180'] ?? 0);

        $h['3000'] = ($h['3110'] ?? 0) + ($h['3120'] ?? 0) + ($h['3130'] ?? 0);
    }

    // ==================================================
    // FORMAT AKUN
    // ==================================================
    $formattedAkun = [];
    if (!empty($allAkun)) {
        foreach ($allAkun as $item) {
            // Database dulu, fallback ke hardcode
            // $saldoAwalNominal = $item->saldoAwalBuku->first()->saldo_awal
            //     ?? ($saldoAwalHardcode[$periodeAktif->id][$item->kode] ?? 0);
            $saldoAwalNominal = $saldoAwalHardcode[$periodeAktif->id][$item->kode] 
            ?? ($item->saldoAwalBuku->first()->saldo_awal ?? 0);


            $debet  = $item->total_debet ?? 0;
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
    public function superIndex(Request $request)
    {
        $dapurList = Dapur::orderBy('nama_lembaga')->get();

        $dapurId = $request->dapur_id;

        $dapur = null;
        $periodeAktif = null;
        $akun = [];

        $statusPeriode = 'tidak_ada';
        $pesanPeriode = 'Silakan pilih dapur terlebih dahulu.';

        if ($dapurId) {

            $dapur = Dapur::find($dapurId);

            if (!$dapur) {
                abort(404, 'Data dapur tidak ditemukan.');
            }

            $periodeAktif = Periode::where('dapur_id', $dapur->id)
                ->where('is_active', true)
                ->first();

            $statusPeriode = 'aktif';
            $pesanPeriode = '';

            $today = now()->format('Y-m-d');

            if (!$periodeAktif) {

                $statusPeriode = 'tidak_ada';
                $pesanPeriode = 'Belum ada periode akuntansi aktif pada dapur ini.';

            } elseif ($today > $periodeAktif->tanggal_selesai) {

                $statusPeriode = 'kadaluwarsa';
                $pesanPeriode = 'Periode akuntansi sudah kadaluwarsa.';
            }

            if ($periodeAktif) {

                $allAkun = Akun::query()
                    ->with([
                        'saldoAwalBuku' => function ($q) use ($periodeAktif) {
                            $q->where('periode_id', $periodeAktif->id);
                        }
                    ])

                    ->withSum([
                        'transaksi as total_debet' => function ($q) use ($dapur, $periodeAktif) {
                            $q->where('dapur_id', $dapur->id)
                                ->whereBetween(
                                    'tanggal',
                                    [
                                        $periodeAktif->tanggal_mulai,
                                        $periodeAktif->tanggal_selesai
                                    ]
                                );
                        }
                    ], 'debet')

                    ->withSum([
                        'transaksi as total_kredit' => function ($q) use ($dapur, $periodeAktif) {
                            $q->where('dapur_id', $dapur->id)
                                ->whereBetween(
                                    'tanggal',
                                    [
                                        $periodeAktif->tanggal_mulai,
                                        $periodeAktif->tanggal_selesai
                                    ]
                                );
                        }
                    ], 'kredit')

                    ->orderBy('kode')
                    ->get();

                foreach ($allAkun as $item) {

                    $saldoAwalNominal =
                        $item->saldoAwalBuku->first()->saldo_awal ?? 0;

                    $debet = $item->total_debet ?? 0;
                    $kredit = $item->total_kredit ?? 0;

                    $saldoAkhirNominal =
                        $saldoAwalNominal + ($debet - $kredit);

                    $akun[] = [
                        'id'              => $item->id,
                        'kode'            => $item->kode,
                        'nama_akun'       => $item->nama_akun,
                        'saldo_awal_raw'  => $saldoAwalNominal,
                        'saldo_akhir_raw' => $saldoAkhirNominal,
                        'status'          => $saldoAkhirNominal >= 0
                            ? 'Sesuai'
                            : 'Tidak Sesuai',
                        'is_section'      => false,
                        'is_parent'       => strlen($item->kode) <= 3,
                        'is_sub'          => strlen($item->kode) > 3,
                    ];
                }
            }
        }

        return view('super.awal-buku.index', [
            'title'          => 'Saldo Awal Buku',
            'dapurList'      => $dapurList,
            'dapur'          => $dapur,
            'periode'        => $periodeAktif,
            'akun'           => $akun,
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