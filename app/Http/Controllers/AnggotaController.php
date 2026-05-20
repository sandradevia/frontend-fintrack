<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;

class AnggotaController extends Controller
{
    // =============================
    // LIST DATA
    // =============================
    public function index()
    {
        $petugas = Anggota::where('dapur_id', session('dapur_id'))->get();

        return view('admin.petugas.index', compact('petugas'));
    }

    // =============================
    // STORE
    // =============================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:100',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
        ]);

        Anggota::create([
            'dapur_id' => session('dapur_id'),
            'nama' => $validated['nama'],
            'jabatan' => $validated['jabatan'] ?? null,
            'no_hp' => $validated['no_hp'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Petugas berhasil ditambahkan',
        ]);
    }

    // =============================
    // UPDATE
    // =============================
    public function update(Request $request, $id)
    {
        $petugas = Anggota::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:100',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
        ]);

        $petugas->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Petugas berhasil diperbarui',
        ]);
    }

    // =============================
    // DELETE
    // =============================
    public function destroy($id)
    {
        $petugas = Anggota::findOrFail($id);
        $petugas->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Petugas berhasil dihapus',
        ]);
    }
}