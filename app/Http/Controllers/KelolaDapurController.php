<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dapur;
use App\Models\User;
use App\Models\Periode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KelolaDapurController extends Controller
{
    public function index()
    {
        $dapur = Dapur::with(['user', 'periode'])->latest()->get();
        return view('super.kelola-dapur.index', compact('dapur'));
    }

    public function create()
    {
        return view('super.kelola-dapur.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'nama_lembaga' => 'required',
        'alamat'       => 'required',
        'nama_kepala_sppg' => 'required',

        'username'     => 'required|unique:users,username',
        'password'     => 'required|min:6',
    ]);

    DB::beginTransaction();

    try {

        // 1. USER
        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role'     => 'dapur',
        ]);

        // 2. DAPUR
        $dapur = Dapur::create([
            'user_id'           => $user->id,
            'nama_lembaga'      => $request->nama_lembaga,
            'alamat'            => $request->alamat,
            'nama_yayasan'      => $request->nama_yayasan,
            'ketua_yayasan'     => $request->ketua_yayasan,
            'nama_kepala_sppg'  => $request->nama_kepala_sppg,
            'nama_akuntan'      => $request->nama_akuntan,
            'nomor_rekening'    => $request->nomor_rekening,
        ]);

        // 3. PERIODE (INI WAJIB ADA KALAU FIELD ADA DI FORM)
        Periode::create([
            'dapur_id'         => $dapur->id,
            'tanggal_pelaporan'=> $request->tanggal_pelaporan,
            'tahun_anggaran'   => $request->tahun_anggaran,
            'periode_saat_ini' => $request->periode_saat_ini,
            'awal_periode_berikutnya' => $request->awal_periode_berikutnya,
            'tempat_pelaporan' => $request->tempat_pelaporan,
        ]);

        DB::commit();

        return redirect()
            ->route('super.kelola-dapur.index')
            ->with('success', 'Data berhasil ditambahkan');

    } catch (\Exception $e) {

        DB::rollback();

        return back()->with('error', $e->getMessage());
    }
}

    public function show($id)
    {
        $dapur = Dapur::with(['user', 'periode'])->findOrFail($id);

        $periode = $dapur->periode()->latest()->first();

        return view('super.kelola-dapur.show', compact('dapur', 'periode'));
    }

    public function edit($id)
    {
        $dapur = Dapur::with(['user', 'periode'])->findOrFail($id);

        // AMBIL 1 PERIODE AKTIF / TERBARU
        $periode = $dapur->periode()->latest()->first();

        return view('super.kelola-dapur.edit', compact('dapur', 'periode'));
    }

    public function update(Request $request, $id)
    {
        $dapur = Dapur::with('user')->findOrFail($id);

        DB::beginTransaction();

        try {

            // USER UPDATE
            if ($dapur->user) {
                $dapur->user->update([
                    'username' => $request->username,
                    'password' => $request->password
                        ? Hash::make($request->password)
                        : $dapur->user->password,
                ]);
            }

            // DAPUR UPDATE
            $dapur->update([
                'nama_lembaga'     => $request->nama_lembaga,
                'alamat'           => $request->alamat,
                'nama_yayasan'     => $request->nama_yayasan,
                'ketua_yayasan'    => $request->ketua_yayasan,
                'nama_kepala_sppg' => $request->nama_kepala_sppg,
                'nama_akuntan'     => $request->nama_akuntan,
                'nomor_rekening'   => $request->nomor_rekening,
            ]);

            // PERIODE UPDATE (ambil terbaru)
            $periode = $dapur->periode()->latest()->first();

            if ($periode) {
                $periode->update([
                    'tahun_anggaran'    => $request->tahun_anggaran,
                    'tanggal_pelaporan' => $request->tanggal_pelaporan,
                ]);
            } else {
                Periode::create([
                    'dapur_id'          => $dapur->id,
                    'tahun_anggaran'    => $request->tahun_anggaran,
                    'tanggal_pelaporan' => $request->tanggal_pelaporan,
                    'tanggal_mulai'     => now(),
                    'is_active'         => true,
                ]);
            }

            DB::commit();

            return redirect()->route('super.kelola-dapur.index')
                ->with('success', 'Data berhasil diupdate');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $dapur = Dapur::findOrFail($id);

        DB::beginTransaction();
        try {

            $dapur->periode()->delete();
            $dapur->user()->delete();
            $dapur->delete();

            DB::commit();

            return redirect()->route('super.kelola-dapur.index')
                ->with('success', 'Berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}