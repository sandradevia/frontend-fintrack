<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use App\Models\Dapur;
use App\Models\Akun;
use App\Models\SaldoAwalBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PeriodeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $dapur = Dapur::find($user->dapur_id);

        if (!$dapur) {
            abort(404, 'Data dapur tidak ditemukan.');
        }

        // Ambil semua histori periode untuk dapur ini
        $allPeriode = Periode::where('dapur_id', $dapur->id)
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.periode.index', [
            'title' => 'Manajemen Periode Akuntansi',
            'dapur' => $dapur,
            'allPeriode' => $allPeriode
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_anggaran' => 'required|numeric|digits:4',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
        ]);

        $user = Auth::user();

        DB::beginTransaction();
        try {
            // 1. Ambil periode aktif saat ini (jika ada) untuk proses gulung saldo awal
            $periodeLama = Periode::where('dapur_id', $user->dapur_id)
                ->where('is_active', true)
                ->first();

            // 2. Nonaktifkan semua periode lama milik dapur ini (Tutup Buku)
            Periode::where('dapur_id', $user->dapur_id)->update(['is_active' => false]);

            // 3. Buat periode 10-harian yang baru
            $periodeBaru = Periode::create([
                'dapur_id' => $user->dapur_id,
                'tahun_anggaran' => $request->tahun_anggaran,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'is_active' => true,
            ]);

            // 4. OTOMATISASI SALDO AWAL (Mulai bergulir dari saldo akhir periode lalu)
            $akuns = Akun::get();
            foreach ($akuns as $akun) {
                $saldoAwalBaru = 0;

                if ($periodeLama) {
                    // Hitung Saldo Awal Riil dari Periode Lama
                    $saldoAwalLama = SaldoAwalBuku::where('periode_id', $periodeLama->id)
                        ->where('akun_id', $akun->id)
                        ->value('saldo_awal') ?? 0;

                    // FIX: Menggunakan whereBetween('tanggal') karena tabel transaksi tidak memiliki 'periode_id'
                    $debet = DB::table('transaksi')
                        ->where('dapur_id', $user->dapur_id)
                        ->where('akun_id', $akun->id)
                        ->whereBetween('tanggal', [$periodeLama->tanggal_mulai, $periodeLama->tanggal_selesai])
                        ->sum('debet') ?? 0;

                    $kredit = DB::table('transaksi')
                        ->where('dapur_id', $user->dapur_id)
                        ->where('akun_id', $akun->id)
                        ->whereBetween('tanggal', [$periodeLama->tanggal_mulai, $periodeLama->tanggal_selesai])
                        ->sum('kredit') ?? 0;

                    // Rumus akumulatif saldo bergulir
                    $saldoAwalBaru = $saldoAwalLama + ($debet - $kredit);
                }

                // Simpan ke tabel bridge saldo_awal_buku untuk periode baru ini
                SaldoAwalBuku::create([
                    'periode_id' => $periodeBaru->id,
                    'akun_id' => $akun->id,
                    'saldo_awal' => $saldoAwalBaru,
                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Periode baru berhasil dibuka dan saldo awal telah digulirkan secara otomatis!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal membuka periode: ' . $e->getMessage());
        }
    }
}