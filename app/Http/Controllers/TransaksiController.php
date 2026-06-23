<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;
use App\Models\Akun;
use App\Models\Dapur;

class TransaksiController extends Controller
{
    /**
     * Fungsi helper untuk generate nomor bukti otomatis berdasarkan tipe (RK / Kwt)
     */
    private function generateNextNoBukti($kode)
    {
        $tahun = date('Y'); // Mengambil tahun berjalan

        // Ambil transaksi terakhir yang formatnya mirip (contoh: %/Kwt/2026 atau %/RK/2026)
        $lastTransaksi = Transaksi::where('no_bukti', 'like', "%/{$kode}/{$tahun}")
            ->orderByRaw("CAST(SPLIT_PART(no_bukti, '/', 1) AS INTEGER) DESC") // Mengurutkan angka depan secara presisi
            ->first();

        if ($lastTransaksi) {
            $lastNumber = explode('/', $lastTransaksi->no_bukti)[0];
            $nextNumber = (int)$lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        return "{$nextNumber}/{$kode}/{$tahun}";
    }

    public function index()
    {
        $user = Auth::user();
        $dapur = Dapur::first();
        $periodeAwal = now()->startOfMonth()->format('d F Y');
        $periodeAkhir = now()->format('d F Y');

        if (!$user) {
            abort(403, 'User tidak ditemukan');
        }

        $transaksi = Transaksi::with('akun')
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        $akun = Akun::orderBy('nama_akun')->get();

        // Generate nomor bukti otomatis untuk dilempar ke view
        $nextRk = $this->generateNextNoBukti('RK');   // Untuk Debet (Uang Masuk)
        $nextKwt = $this->generateNextNoBukti('Kwt'); // Untuk Kredit (Uang Keluar)

        return view('admin.transaksi.transaksi', [
            'title' => 'Transaksi',
            'user' => $user,
            'transaksi' => $transaksi,
            'akun' => $akun,
            'periodeAwal' => $periodeAwal,
            'periodeAkhir' => $periodeAkhir,
            'dapur' => $dapur,
            'nextRk' => $nextRk,     // Pastikan ini terkirim
            'nextKwt' => $nextKwt,   // Pastikan ini terkirim
        ]);
    }

    public function store(Request $request)
    {
        // Tentukan kodenya dulu sebelum validasi unik agar nomor benar-benar fresh dari server
        $kode = ((float)$request->debet > 0) ? 'RK' : 'Kwt';
        $request->merge([
            'no_bukti' => $this->generateNextNoBukti($kode)
        ]);

        $request->validate([
            'akun_id' => 'required|exists:akun,id',
            'tanggal' => 'required|date',
            'no_bukti' => 'required|unique:transaksi,no_bukti',
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
            ->route('admin.transaksi.transaksi')
            ->with('success', 'Transaksi berhasil ditambahkan');
    }

    public function update(Request $request, string $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $request->validate([
            'akun_id' => 'required|exists:akun,id',
            'tanggal' => 'required|date',
            'no_bukti' => 'required|unique:transaksi,no_bukti,' . $id,
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
            ->route('admin.transaksi.transaksi')
            ->with('success', 'Transaksi berhasil diubah');
    }

    public function destroy(string $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $transaksi->delete();

        return redirect()
            ->route('admin.transaksi.transaksi')
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
    public function superIndex(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'User tidak ditemukan');
        }

        $dapurId = $request->get('dapur_id'); // untuk filter/search

        // base query transaksi
        $query = Transaksi::with(['akun', 'dapur'])
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc');

        // 🔥 role-based access
        if ($user->role !== 'super_admin') {
            $query->where('dapur_id', $user->dapur_id);
        } else {
            // super admin bisa filter per dapur
            if ($dapurId) {
                $query->where('dapur_id', $dapurId);
            }
        }

        $transaksi = $query->get();

        $akun = Akun::orderBy('nama_akun')->get();
        $dapurList = Dapur::orderBy('nama_lembaga')->get();

        $periodeAwal = now()->startOfMonth()->format('d F Y');
        $periodeAkhir = now()->format('d F Y');

        $nextRk = $this->generateNextNoBukti('RK');
        $nextKwt = $this->generateNextNoBukti('Kwt');

        return view('super.transaksi.index', [
            'title' => 'Transaksi',
            'user' => $user,
            'transaksi' => $transaksi,
            'akun' => $akun,
            'dapurList' => $dapurList,   // untuk dropdown filter super admin
            'periodeAwal' => $periodeAwal,
            'periodeAkhir' => $periodeAkhir,
            'dapur' => Dapur::first(),
            'nextRk' => $nextRk,
            'nextKwt' => $nextKwt,
            'selectedDapur' => $dapurId, // biar UI bisa retain filter
        ]);
    }
}