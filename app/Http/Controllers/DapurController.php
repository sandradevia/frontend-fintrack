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
        'nama_lembaga' => 'required|string|max:255',
        'alamat' => 'required|string|max:500', // Sesuai dengan 'required' di form
        'nama_kepala_sppg' => 'required|string|max:255',
        'nama_akuntan' => 'nullable|string|max:255',
        'nama_yayasan' => 'nullable|string|max:255',
        'ketua_yayasan' => 'nullable|string|max:255',
        'nomor_rekening' => 'nullable|string|max:50',
        'tempat_pelaporan' => 'nullable|string|max:255',
        'username' => 'required|string|max:50|unique:users,username',
        'password' => 'required|string|min:8', // Konsisten 8 karakter
    ]);

    $dapur = Dapur::create([
        'nama_lembaga' => $validated['nama_lembaga'],
        'alamat' => $validated['alamat'],
        'nama_kepala_sppg' => $validated['nama_kepala_sppg'],
        'nama_akuntan' => $validated['nama_akuntan'] ?? null,
        'nama_yayasan' => $validated['nama_yayasan'] ?? null,
        'ketua_yayasan' => $validated['ketua_yayasan'] ?? null,
        'nomor_rekening' => $validated['nomor_rekening'] ?? null,
        'tempat_pelaporan' => $validated['tempat_pelaporan'] ?? null,
    ]);
    dd($request->all());

    User::create([
        'username' => $validated['username'],
        'password' => Hash::make($validated['password']),
        'dapur_id' => $dapur->id,
    ]);

    return redirect()->route('super.kelola-dapur.index')->with('success', 'Dapur dan User berhasil ditambahkan.');

    }

    // =============================
    // UPDATE
    // =============================
    public function update(Request $request, $id)
{
    $dapur = Dapur::with(['user'])->findOrFail($id);

    $validated = $request->validate([
        'nama_lembaga' => 'required|string|max:255',
        'alamat'       => 'nullable|string|max:500',
        // ... (field lainnya tetap)
        
        // Perbaikan validasi: Mengabaikan ID user yang sedang diedit
        'username' => 'required|string|max:50|unique:users,username,' . ($dapur->user ? $dapur->user->id : 'NULL'),
        'password' => 'nullable|string|min:8', // Sesuai dengan instruksi UI Anda (8 karakter)
    ]);

    // Update Dapur
    $dapur->update([
        'nama_lembaga'     => $validated['nama_lembaga'],
        'alamat'           => $validated['alamat'],
        'nama_kepala_sppg' => $request->nama_kepala_sppg,
        'nama_akuntan'     => $request->nama_akuntan,
        'nama_yayasan'     => $request->nama_yayasan,
        'ketua_yayasan'    => $request->ketua_yayasan,
        'nomor_rekening'   => $request->nomor_rekening,
        'tempat_pelaporan' => $request->tempat_pelaporan,
    ]);

    // Update User
    if ($dapur->user) {
        $userData = [
            'username' => $validated['username'],
        ];

        // Hanya update password jika diisi
        if (!empty($validated['password'])) {
            $userData['password'] = Hash::make($validated['password']);
        }

        $dapur->user->update($userData);
    } else {
        User::create([
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'dapur_id' => $dapur->id,
        ]);
    }

    return redirect()->back()->with('success', 'Data profil berhasil diperbarui.');
}
}