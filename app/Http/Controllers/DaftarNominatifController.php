<?php

namespace App\Http\Controllers;

use App\Models\DaftarNominatif;
use App\Models\KehadiranNominatif;
use App\Models\Anggota;
use App\Models\Pekerjaan;
use App\Models\Dapur;
use App\Exports\DaftarNominatifExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Models\Periode;
use Illuminate\Support\Facades\DB;


class DaftarNominatifController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'User tidak ditemukan');
        }

        $anggotas = Anggota::with('pekerjaan')
            ->where('dapur_id', $user->dapur_id)
            ->orderBy('nama')
            ->get();

        $periodeAktif = Periode::where('is_active', true)->first();

        $pekerjaans = Pekerjaan::orderBy('nama_pekerjaan')->get();

        $nominatifs = DaftarNominatif::with([
                'anggota.pekerjaan',
                'kehadiranNominatif'
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
            'pekerjaans' => $pekerjaans,
            'nominatifs' => $nominatifs,
            'hariKerjaBerjalan' => $hariKerjaBerjalan,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'tanggalKerja' => $tanggalKerja,
            'periodeAktif' => $periodeAktif,
        ]);
    }

    public function superIndex(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'User tidak ditemukan');
        }

        $dapurId = $request->dapur_id;

        $anggotas = Anggota::with('pekerjaan')
            ->when($dapurId, function ($q) use ($dapurId) {
                $q->where('dapur_id', $dapurId);
            })
            ->orderBy('nama')
            ->get();

        $periodeAktif = Periode::where('is_active', true)
            ->when($dapurId, function ($q) use ($dapurId) {
                $q->where('dapur_id', $dapurId);
            })
            ->first();

        $pekerjaans = Pekerjaan::orderBy('nama_pekerjaan')->get();

        $nominatifs = DaftarNominatif::with([
                'anggota.pekerjaan',
                'kehadiranNominatif'
            ])
            ->when($dapurId, function ($q) use ($dapurId) {
                $q->where('dapur_id', $dapurId);
            })
            ->orderBy('tanggal', 'desc')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | KEHADIRAN GLOBAL / PER DAPUR
        |--------------------------------------------------------------------------
        */
        $kehadiranQuery = KehadiranNominatif::query()
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year);

        if ($dapurId) {
            $kehadiranQuery->whereHas('daftarNominatif', function ($q) use ($dapurId) {
                $q->where('dapur_id', $dapurId);
            });
        }

        $hariKerjaBerjalan = min(
            (clone $kehadiranQuery)->distinct('tanggal')->count('tanggal'),
            25
        );

        $bulan = Carbon::now()->translatedFormat('F');
        $tahun = Carbon::now()->year;

        $tanggalKerja = (clone $kehadiranQuery)
            ->select('tanggal')
            ->distinct()
            ->orderBy('tanggal')
            ->pluck('tanggal');

        $dapurList = Dapur::orderBy('nama_lembaga')->get();

        return view('super.daftar-nominatif.index', [
            'title' => 'Daftar Nominatif',
            'user' => $user,

            'dapurList' => $dapurList,
            'selectedDapur' => $dapurId,

            'anggotas' => $anggotas,
            'pekerjaans' => $pekerjaans,
            'nominatifs' => $nominatifs,

            'hariKerjaBerjalan' => $hariKerjaBerjalan,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'tanggalKerja' => $tanggalKerja,

            'periodeAktif' => $periodeAktif,
        ]);
    }

    // ================= CREATE =================
    public function store(Request $request)
{
    try {
        // Logika simpan data
        $totalHonor = $request->honor_harian * count($request->tanggal_hadir);
        $totalAkhir = $totalHonor + ($request->dana_sehat ?? 0) + ($request->transport ?? 0) - ($request->pajak ?? 0);

        $nominatif = DaftarNominatif::create([
            'dapur_id'   => Auth::user()->dapur_id,
            'anggota_id' => $request->anggota_id,
            'no_bukti'   => $request->no_bukti,
            'tanggal'    => now(), 
            'honor'      => $totalHonor,
            'dana_sehat' => $request->dana_sehat ?? 0,
            'transport'  => $request->transport ?? 0,
            'pajak'      => $request->pajak ?? 0,
            'total'      => $totalAkhir,
            'status'     => 'pending',
        ]);

        foreach ($request->tanggal_hadir as $tgl) {
            KehadiranNominatif::create([
                'daftar_nominatif_id' => $nominatif->id,
                'tanggal' => $tgl,
                'honor_harian' => $request->honor_harian,
            ]);
        }

        return back()->with('success', 'Data berhasil disimpan!');

    } catch (\Exception $e) {
        // JIKA GAGAL, KITA AKAN TAHU KENAPA
        return back()->with('error', 'Gagal Simpan: ' . $e->getMessage());
    }
}



public function update(Request $request, $id)
{
    $nominatif = DaftarNominatif::findOrFail($id);

    $request->validate([
        'anggota_id' => 'required|exists:anggota,id',
        'honor_harian' => 'required|numeric|min:0',
        'tanggal_hadir' => 'required|array|min:1',
    ]);

    DB::transaction(function () use ($request, $nominatif) {
        $totalHonor = $request->honor_harian * count($request->tanggal_hadir);
        // Hitung ulang total dengan mempertahankan data lama atau input baru
        $totalAkhir = $totalHonor + $nominatif->dana_sehat + $nominatif->transport - $nominatif->pajak;

        $nominatif->update([
            'anggota_id' => $request->anggota_id,
            'honor' => $totalHonor,
            'total' => $totalAkhir,
        ]);

        // Re-sync kehadiran
        $nominatif->kehadiranNominatif()->delete();
        
        foreach ($request->tanggal_hadir as $tgl) {
            $nominatif->kehadiranNominatif()->create([
                'tanggal' => $tgl,
                'honor_harian' => $request->honor_harian,
            ]);
        }
    });

    return back()->with('success', 'Data berhasil diperbarui.');
}

    public function destroy($id)
    {
        $nominatif = DaftarNominatif::findOrFail($id);
        
        // Hapus detail dulu karena foreign key cascadeOnDelete sudah aktif
        // Tapi kita hapus manual untuk memastikan konsistensi
        KehadiranNominatif::where('daftar_nominatif_id', $id)->delete();
        $nominatif->delete();

        return redirect()->route('admin.daftar-nominatif.index')
            ->with('success', 'Data berhasil dihapus.');
    }

    public function exportExcel()
    {
        return Excel::download(
            new DaftarNominatifExport(Auth::user()->dapur_id),
            'daftar-nominatif-' . now()->format('Ymd-His') . '.xlsx'
        );
    }
}