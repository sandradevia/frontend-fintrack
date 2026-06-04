<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Anggota;
use App\Models\Dapur;
use App\Models\Pekerjaan;

class AnggotaController extends Controller
{
    // =============================
    // LIST DATA
    // =============================
    public function index()
    {
        $user = Auth::user();

        $dapur = Dapur::find($user->dapur_id);

        // Ambil anggota sesuai dapur
        $anggota = Anggota::with('pekerjaan')
            ->where('dapur_id', $dapur?->id)
            ->latest()
            ->get();

        // Data pekerjaan
        $pekerjaan = Pekerjaan::latest()->get();

        return view('admin.petugas.index', compact(
            'anggota',
            'pekerjaan'
        ));
    }

    // =============================
    // STORE
    // =============================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'pekerjaan_id' => 'required|exists:pekerjaans,id',
        ]);

        $user = Auth::user();

        $dapur = Dapur::where('user_id', $user->id)->first();

        Anggota::create([
            'nama' => $validated['nama'],
            'pekerjaan_id' => $validated['pekerjaan_id'],
            'dapur_id' => $dapur?->id,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Anggota berhasil ditambahkan');
    }

    // =============================
    // UPDATE
    // =============================
    public function update(Request $request, $id)
    {
        $anggota = Anggota::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'pekerjaan_id' => 'required|exists:pekerjaans,id',
        ]);

        $anggota->update([
            'nama' => $validated['nama'],
            'pekerjaan_id' => $validated['pekerjaan_id'],
        ]);

        return redirect()
            ->back()
            ->with('success', 'Anggota berhasil diperbarui');
    }

    // =============================
    // DELETE
    // =============================
    public function destroy($id)
    {
        $anggota = Anggota::findOrFail($id);

        $anggota->delete();

        return redirect()
            ->back()
            ->with('success', 'Anggota berhasil dihapus');
    }
}