<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Dapur;
use Illuminate\Support\Facades\Hash;

class DapurController extends Controller
{
    // Method yang sudah ada
    public function pilih($id)
    {
        session([
            'dapur_id' => $id
        ]);

        return response()->json([
            'status' => 'success'
        ]);
    }

    // Method baru untuk menampilkan profil dapur
    public function index()
    {
        $dapur = Dapur::with('periodeAktif')->findOrFail(session('dapur_id'));
        return view('admin.profile.profile', compact('dapur'));
    }

    // Method baru untuk update data dapur
    public function update(Request $request, $id)
    {
        $dapur = Dapur::findOrFail($id);

        $validated = $request->validate([
            'nama_lemabaga' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:500',
            'nama_kepala_sppg' => 'nullable|string|max:255',
            'nama_akuntan' => 'nullable|string|max:255',
            'nama_yayasan' => 'nullable|string|max:255',
            'ketua_yayasan' => 'nullable|string|max:255',
            'nomor_rekening' => 'nullable|string|max:50',
            'tanggal_pelaporan' => 'nullable|date',
            'tempat_pelaporan' => 'nullable|string|max:255',
        ]);

        $dapur->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Data dapur berhasil diperbarui',
            'data' => $dapur,
        ]);
    }
}