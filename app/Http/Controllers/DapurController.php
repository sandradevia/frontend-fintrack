<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dapur;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DapurController extends Controller
{
    public function pilih($id)
    {
        session([
            'dapur_id' => $id
        ]);

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function index()
    {
        $dapur = Dapur::with(['user'])->findOrFail(session('dapur_id'));
        return view('admin.profile.profile', compact('dapur'));
    }

    // =============================
    // STORE
    // =============================
    public function store(Request $request)
    {
        $validated = $request->validate([
            // dapur
            'nama_lembaga' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:500',
            'nama_kepala_sppg' => 'nullable|string|max:255',
            'nama_akuntan' => 'nullable|string|max:255',
            'nama_yayasan' => 'nullable|string|max:255',
            'ketua_yayasan' => 'nullable|string|max:255',
            'nomor_rekening' => 'nullable|string|max:50',
            'tempat_pelaporan' => 'nullable|string|max:255',

            // user
            'username' => 'required|string|max:50|unique:users,username',
            'password' => 'required|string|min:6',
        ]);

        // =====================
        // SIMPAN DAPUR
        // =====================
        $dapur = Dapur::create([
            'nama_lembaga' => $validated['nama_lembaga'],
            'alamat' => $validated['alamat'] ?? null,
            'nama_kepala_sppg' => $validated['nama_kepala_sppg'] ?? null,
            'nama_akuntan' => $validated['nama_akuntan'] ?? null,
            'nama_yayasan' => $validated['nama_yayasan'] ?? null,
            'ketua_yayasan' => $validated['ketua_yayasan'] ?? null,
            'nomor_rekening' => $validated['nomor_rekening'] ?? null,
            'tempat_pelaporan' => $validated['tempat_pelaporan'] ?? null,
        ]);

        // =====================
        // SIMPAN USER LOGIN
        // =====================
        User::create([
            'name' => $validated['nama_lembaga'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'dapur_id' => $dapur->id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Dapur + User berhasil ditambahkan',
        ]);
    }

    // =============================
    // UPDATE
    // =============================
    public function update(Request $request, $id)
    {
        $dapur = Dapur::with(['user'])->findOrFail($id);

        $validated = $request->validate([
            // dapur
            'nama_lembaga' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:500',
            'nama_kepala_sppg' => 'nullable|string|max:255',
            'nama_akuntan' => 'nullable|string|max:255',
            'nama_yayasan' => 'nullable|string|max:255',
            'ketua_yayasan' => 'nullable|string|max:255',
            'nomor_rekening' => 'nullable|string|max:50',
            'tempat_pelaporan' => 'nullable|string|max:255',

            // user
            'username' => 'nullable|string|max:50|unique:users,username,' . ($dapur->user->id ?? 'NULL'),
            'password' => 'nullable|string|min:6',
        ]);

        // =====================
        // UPDATE DAPUR
        // =====================
        $dapur->update([
            'nama_lembaga' => $validated['nama_lembaga'],
            'alamat' => $validated['alamat'] ?? null,
            'nama_kepala_sppg' => $validated['nama_kepala_sppg'] ?? null,
            'nama_akuntan' => $validated['nama_akuntan'] ?? null,
            'nama_yayasan' => $validated['nama_yayasan'] ?? null,
            'ketua_yayasan' => $validated['ketua_yayasan'] ?? null,
            'nomor_rekening' => $validated['nomor_rekening'] ?? null,
            'tempat_pelaporan' => $validated['tempat_pelaporan'] ?? null,
        ]);

        // =====================
        // UPDATE USER
        // =====================
        if ($dapur->user) {
            $dapur->user->update([
                'username' => $validated['username'] ?? $dapur->user->username,
                'password' => !empty($validated['password'])
                    ? Hash::make($validated['password'])
                    : $dapur->user->password,
            ]);
        }

         return redirect()
            ->route('admin.profile.profile')
            ->with('success', 'Data nominatif berhasil dihapus.');
    }
}