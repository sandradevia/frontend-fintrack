<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;
use App\Models\Akun;

class TransaksiController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'User tidak ditemukan');
        }

        $transaksis = Transaksi::with('akun')
            ->orderBy('tanggal', 'desc')
            ->get();

        $akuns = Akun::orderBy('nama_akun')->get();

        return view('admin.transaksi.transaksi', [
            'title' => 'Transaksi',
            'user' => $user,
            'transaksis' => $transaksis,
            'akuns' => $akuns,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'akun_id' => 'required|exists:akuns,id',
            'tanggal' => 'required|date',
            'no_bukti' => 'required|unique:transaksis,no_bukti',
            'uraian' => 'required|string|max:255',
            'debet' => 'nullable|numeric|min:0',
            'kredit' => 'nullable|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        Transaksi::create([
            'dapur_id' => Auth::user()->dapur_id,
            'akun_id' => $request->akun_id,
            'tanggal' => $request->tanggal,
            'no_bukti' => $request->no_bukti,
            'uraian' => $request->uraian,
            'debet' => $request->debet ?? 0,
            'kredit' => $request->kredit ?? 0,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()
            ->route('transaksi.index')
            ->with('success', 'Transaksi berhasil ditambahkan');
    }

    public function update(Request $request, string $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $request->validate([
            'akun_id' => 'required|exists:akuns,id',
            'tanggal' => 'required|date',
            'no_bukti' => 'required|unique:transaksis,no_bukti,' . $id,
            'uraian' => 'required|string|max:255',
            'debet' => 'nullable|numeric|min:0',
            'kredit' => 'nullable|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $transaksi->update([
            'akun_id' => $request->akun_id,
            'tanggal' => $request->tanggal,
            'no_bukti' => $request->no_bukti,
            'uraian' => $request->uraian,
            'debet' => $request->debet ?? 0,
            'kredit' => $request->kredit ?? 0,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()
            ->route('transaksi.index')
            ->with('success', 'Transaksi berhasil diubah');
    }

    public function destroy(string $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $transaksi->delete();

        return redirect()
            ->route('transaksi.index')
            ->with('success', 'Transaksi berhasil dihapus');
    }

    public function searchAkun(Request $request)
    {
        $search = $request->q;

        $akuns = Akun::query()
            ->when($search, function ($query) use ($search) {
                $query->where('kode', 'ilike', "%{$search}%")
                    ->orWhere('nama_akun', 'ilike', "%{$search}%");
            })
            ->limit(20)
            ->get();

        return response()->json(
            $akuns->map(function ($akun) {
                return [
                    'id' => $akun->id,
                    'text' => $akun->kode . ' - ' . $akun->nama_akun,
                ];
            })
        );
    }
}