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

        // 1. DAPUR
        $dapur = Dapur::create([
            'nama_lembaga'      => $request->nama_lembaga,
            'alamat'            => $request->alamat,
            'nama_yayasan'      => $request->nama_yayasan,
            'ketua_yayasan'     => $request->ketua_yayasan,
            'nama_kepala_sppg'  => $request->nama_kepala_sppg,
            'nama_akuntan'      => $request->nama_akuntan,
            'nomor_rekening'    => $request->nomor_rekening,
            'tempat_pelaporan'  => $request->tempat_pelaporan,
        ]);

        // 2. USER
        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role'     => 'admin_dapur',
            'dapur_id' => $dapur->id, // sesuaikan PK tabel dapur
        ]);
        $user->assignRole('admin_dapur');

        DB::commit();

        return redirect()
            ->route('super.kelola-dapur.index')
            ->with('success', 'Data berhasil ditambahkan');

    } catch (\Exception $e) {

    DB::rollBack();

    dd($e->getMessage());

    }
}

    public function show($id)
    {
        $dapur = Dapur::with('user')->findOrFail($id);


        return view('super.kelola-dapur.show', compact('dapur'));
    }

    public function edit($id)
    {
        $dapur = Dapur::with('user')->findOrFail($id);


        return view('super.kelola-dapur.edit', compact('dapur'));
    }

    public function update(Request $request, $id)
{
    $dapur = Dapur::with('user')->findOrFail($id);

    DB::beginTransaction();

    try {

        if ($dapur->user) {
            $dapur->user->update([
                'username' => $request->username,
                'password' => $request->password
                    ? Hash::make($request->password)
                    : $dapur->user->password,
            ]);
        }

        $dapur->update([
            'nama_lembaga'     => $request->nama_lembaga,
            'alamat'           => $request->alamat,
            'nama_yayasan'     => $request->nama_yayasan,
            'ketua_yayasan'    => $request->ketua_yayasan,
            'nama_kepala_sppg' => $request->nama_kepala_sppg,
            'nama_akuntan'     => $request->nama_akuntan,
            'nomor_rekening'   => $request->nomor_rekening,
        ]);

        DB::commit();

        return redirect()
            ->route('super.kelola-dapur.index')
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

        $dapur->user()->delete();
        $dapur->delete();

        DB::commit();

        return redirect()
            ->route('super.kelola-dapur.index')
            ->with('success', 'Berhasil dihapus');

    } catch (\Exception $e) {

        DB::rollBack();

        return back()->with('error', $e->getMessage());
    }
}
}