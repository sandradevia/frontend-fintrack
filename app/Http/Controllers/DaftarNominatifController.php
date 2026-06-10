<?php

namespace App\Http\Controllers;

use App\Models\DaftarNominatif;
use App\Models\KehadiranNominatif;
use App\Models\Anggota;
use App\Models\Pekerjaan;
use App\Exports\DaftarNominatifExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Models\Periode;

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

    public function store(Request $request)
    {
        $request->validate([
            'anggota_id' => 'required|exists:anggota,id',
            'tanggal' => 'required|date',
            'no_bukti' => 'required|string|max:100',
            'honor' => 'required|numeric|min:0',
            'dana_sehat' => 'nullable|numeric|min:0',
            'transport' => 'nullable|numeric|min:0',
            'pajak' => 'nullable|numeric|min:0',
        ]);

        $total =
            ($request->honor ?? 0) +
            ($request->dana_sehat ?? 0) +
            ($request->transport ?? 0) -
            ($request->pajak ?? 0);

        DaftarNominatif::create([
            'dapur_id' => Auth::user()->dapur_id,
            'anggota_id' => $request->anggota_id,
            'tanggal' => $request->tanggal,
            'no_bukti' => $request->no_bukti,
            'honor' => $request->honor,
            'dana_sehat' => $request->dana_sehat ?? 0,
            'transport' => $request->transport ?? 0,
            'pajak' => $request->pajak ?? 0,
            'total' => $total,
        ]);

        return redirect()
            ->route('admin.daftar-nominatif.index')
            ->with('success', 'Data nominatif berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'anggota_id' => 'required|exists:anggota,id',
            'tanggal' => 'required|date',
            'no_bukti' => 'required|string|max:100',
            'honor' => 'required|numeric|min:0',
            'dana_sehat' => 'nullable|numeric|min:0',
            'transport' => 'nullable|numeric|min:0',
            'pajak' => 'nullable|numeric|min:0',
        ]);

        $nominatif = DaftarNominatif::findOrFail($id);


        $total =
            ($request->honor ?? 0) +
            ($request->dana_sehat ?? 0) +
            ($request->transport ?? 0) -
            ($request->pajak ?? 0);

        $nominatif->update([
            'anggota_id' => $request->anggota_id,
            'tanggal' => $request->tanggal,
            'no_bukti' => $request->no_bukti,
            'honor' => $request->honor,
            'dana_sehat' => $request->dana_sehat ?? 0,
            'transport' => $request->transport ?? 0,
            'pajak' => $request->pajak ?? 0,
            'total' => $total,
        ]);

        return redirect()
            ->route('admin.daftar-nominatif.index')
            ->with('success', 'Data nominatif berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $nominatif = DaftarNominatif::findOrFail($id);

        KehadiranNominatif::where(
            'daftar_nominatif_id',
            $nominatif->id
        )->delete();

        $nominatif->delete();

        return redirect()
            ->route('admin.daftar-nominatif.index')
            ->with('success', 'Data nominatif berhasil dihapus.');
    }

    public function exportExcel()
    {
        return Excel::download(
            new DaftarNominatifExport(Auth::user()->dapur_id),
            'daftar-nominatif-' . now()->format('Ymd-His') . '.xlsx'
        );
    }
}