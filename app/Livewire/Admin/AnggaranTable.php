<?php

namespace App\Models;
namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\AnggaranBahan;
use App\Models\AnggaranOperasional;
use App\Models\AnggaranInsentif;
use App\Models\DetailAnggaranBahan;

class AnggaranTable extends Component
{
    // Disinkronkan ke query string ?tab=...
    #[Url(as: 'tab')]
    public $activeTab = 'bahan';

    // Modal
    public $showModalTambah = false;

    // Form Properti Utama
    public $kategoriAnggaran = '';
    public $tanggal;
    public $harga_satuan = 0;       // MBG 1 (KB/TK, SD 1-3, Balita)
    public $harga_satuan_2 = 0;     // MBG 2 (SD 4-6, SMP, SMA, Bumil, Busui)
    public $keterangan;
    public $anggaran_bahan_id;

    // Properti Hasil Kalkulasi yang akan dibaca langsung oleh Blade
    public $jumlah_paket = 0;
    public $total_rab = 0;

    // Array Input Data Siswa Berdasarkan ID
    public $jumlah_siswa = [
        1 => 0,
        2 => 0,
        3 => 0,
        4 => 0,
        5 => 0,
        6 => 0,
        7 => 0,
        8 => 0
    ];

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    /**
     * FUNGSI MANDIRI UNTUK MENGHITUNG PORSI DAN NOMINAL RAB
     */
    public function hitungKalkulasiOtomatis()
    {
        // 1. Hitung Total Porsi Paket
        $daftar_jumlah = array_map(function($nilai) {
            return is_numeric($nilai) ? (int)$nilai : 0;
        }, $this->jumlah_siswa ?? []);

        $this->jumlah_paket = array_sum($daftar_jumlah);

        // 2. Hitung Estimasi Total RAB Berdasarkan Kelompok Tarif
        // Kelompok 1 (ID 1 = KB/TK, ID 2 = SD 1-3, ID 6 = Balita)
        $kelompok1 = (int)($this->jumlah_siswa[1] ?? 0) + 
                     (int)($this->jumlah_siswa[2] ?? 0) + 
                     (int)($this->jumlah_siswa[6] ?? 0);
        
        // Kelompok 2 (ID 3 = SD 4-6, ID 4 = SMP, ID 5 = SMA, ID 7 = Bumil, ID 8 = Busui)
        $kelompok2 = (int)($this->jumlah_siswa[3] ?? 0) + 
                     (int)($this->jumlah_siswa[4] ?? 0) + 
                     (int)($this->jumlah_siswa[5] ?? 0) + 
                     (int)($this->jumlah_siswa[7] ?? 0) + 
                     (int)($this->jumlah_siswa[8] ?? 0);

        $harga1 = is_numeric($this->harga_satuan) ? (float)$this->harga_satuan : 0;
        $harga2 = is_numeric($this->harga_satuan_2) ? (float)$this->harga_satuan_2 : 0;

        // Amankan nilai total akhir ke variabel penampung
        $this->total_rab = ($kelompok1 * $harga1) + ($kelompok2 * $harga2);
    }

    /**
     * LIFECYCLE HOOK SENSOR LIVEWIRE 3
     * Berjalan otomatis setiap kali ada ketikan di modal form
     */
    public function updated($propertyName)
    {
        if ($this->kategoriAnggaran === 'bahan') {
            $this->hitungKalkulasiOtomatis();
        }

        elseif ($this->kategoriAnggaran === 'insentif') {
            // Pastikan id acuan bahan dan harga satuan tidak kosong/nol
            if (!empty($this->anggaran_bahan_id) && (float)$this->harga_satuan > 0) {
                
                // Paksa ID menjadi integer agar query pencarian DB akurat
                $bahanId = (int)$this->anggaran_bahan_id;
                $bahan = \App\Models\AnggaranBahan::find($bahanId);
                
                if ($bahan) {
                    // Ambil jumlah porsi/paket dari record anggaran_bahan terpilih
                    $porsiPaket = (int)$bahan->jumlah_paket;
                    $hargaInsentif = (float)$this->harga_satuan;

                    // Hitung riil kalkulasi RAB Insentif
                    $this->total_rab = $porsiPaket * $hargaInsentif;
                } else {
                    $this->total_rab = 0;
                }
            } else {
                // Reset ke 0 jika input acuan belum lengkap
                $this->total_rab = 0;
            }
        }
    }

    // Hapus fungsi getJumlahPaketProperty(), getTotalRabProperty() dan updatedJumlahSiswa() yang lama...

    public function openTambahModal()
    {
        $this->resetForm();
        $this->showModalTambah = true;
    }

    public function closeTambahModal()
    {
        $this->showModalTambah = false;
    }

    private function resetForm()
    {
        $this->reset([
            'kategoriAnggaran',
            'tanggal',
            'harga_satuan',
            'harga_satuan_2',
            'keterangan',
            'anggaran_bahan_id',
            'jumlah_paket',
            'total_rab'
        ]);
        $this->jumlah_siswa = [1=>0, 2=>0, 3=>0, 4=>0, 5=>0, 6=>0, 7=>0, 8=>0];
    }

    private function simpanBahan()
    {
        $this->validate([
            'tanggal'        => 'required|date',
            'harga_satuan'   => 'required|numeric|min:0',
            'harga_satuan_2' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () {
            // Pastikan perhitungan dijalankan sekali lagi sebelum masuk ke Database
            $this->hitungKalkulasiOtomatis();

            $anggaran = AnggaranBahan::create([
                'dapur_id'       => Auth::user()->dapur_id,
                'tanggal'        => $this->tanggal,
                'jumlah_paket'   => $this->jumlah_paket,
                'harga_satuan'   => $this->harga_satuan,
                'harga_satuan_2' => $this->harga_satuan_2,
                'total_rab'      => $this->total_rab,
                'status'         => 'pending',
            ]);

            if (!empty($this->jumlah_siswa)) {
                foreach ($this->jumlah_siswa as $kategoriId => $jumlah) {
                    if ((int)$jumlah > 0) {
                        DetailAnggaranBahan::create([
                            'anggaran_bahan_id'    => $anggaran->id,
                            'kategori_penerima_id' => $kategoriId,
                            'jumlah'               => (int)$jumlah,
                        ]);
                    }
                }
            }
        });
    }

    // Sisa fungsi simpanOperasional, simpanInsentif, simpan, getData, getSummary, dan render tetap biarkan seperti aslinya...

    private function simpanOperasional()
    {
        $this->validate([
            'tanggal' => 'required|date',
            'total_rab' => 'required|numeric|min:1',
        ]);

        AnggaranOperasional::create([
            'dapur_id'  => Auth::user()->dapur_id,
            'tanggal'   => $this->tanggal,
            'keterangan'=> $this->keterangan,
            'total_rab' => $this->total_rab,
        ]);
    }

    private function simpanInsentif()
    {
        $this->validate([
            'tanggal' => 'required|date',
            'harga_satuan' => 'required|numeric|min:1',
            'anggaran_bahan_id' => 'required',
        ]);

        $bahan = AnggaranBahan::findOrFail(
            $this->anggaran_bahan_id
        );

        AnggaranInsentif::create([
            'dapur_id'           => Auth::user()->dapur_id,
            'anggaran_bahan_id'  => $bahan->id,
            'tanggal'            => $this->tanggal,
            'harga_satuan'       => $this->harga_satuan,
            'total_rab'          => $bahan->jumlah_paket * $this->harga_satuan,
        ]);
    }

    public function simpan()
    {
        if ($this->kategoriAnggaran === 'bahan') {

            $this->simpanBahan();

        } elseif ($this->kategoriAnggaran === 'operasional') {

            $this->simpanOperasional();

        } elseif ($this->kategoriAnggaran === 'insentif') {

            $this->simpanInsentif();
        }

        $this->showModalTambah = false;

        session()->flash(
            'success',
            'Data anggaran berhasil ditambahkan.'
        );

        $this->resetForm();
    }

    /**
     * Ambil data sesuai tab aktif, dengan filter dapur_id
     * untuk role selain admin_yayasan.
     */
    private function getData()
    {
        $user = Auth::user();

        $query = match ($this->activeTab) {
            'bahan'       => AnggaranBahan::with(['dapur', 'details.kategoriPenerima']),
            'operasional' => AnggaranOperasional::with(['dapur']),
            'insentif'    => AnggaranInsentif::with(['dapur', 'bahan']),
            default       => null,
        };

        if (! $query) {
            return collect();
        }

        if ($user->role !== 'admin_yayasan') {
            $query->where('dapur_id', $user->dapur_id);
        }

        return $query->latest()->get();
    }

    /**
     * Ringkasan total per kategori, dengan filter dapur_id
     * yang sama seperti getData(), supaya konsisten.
     */
    private function getSummary()
    {
        $user = Auth::user();

        $bahanQuery       = AnggaranBahan::query();
        $operasionalQuery = AnggaranOperasional::query();
        $insentifQuery    = AnggaranInsentif::query();

        if ($user->role !== 'admin_yayasan') {
            $bahanQuery->where('dapur_id', $user->dapur_id);
            $operasionalQuery->where('dapur_id', $user->dapur_id);
            $insentifQuery->where('dapur_id', $user->dapur_id);
        }

        return [
            'bahan' => [
                'count' => $bahanQuery->count(),
                'total' => $bahanQuery->sum('total_rab'),
            ],
            'operasional' => [
                'count' => $operasionalQuery->count(),
                'total' => $operasionalQuery->sum('total_rab'),
            ],
            'insentif' => [
                'count' => $insentifQuery->count(),
                'total' => $insentifQuery->sum('total_rab'),
            ],
        ];
    }

    public function render()
    {
        $user = Auth::user();
    
    return view('livewire.admin.anggaran-table', [
        'items'             => $this->getData(),
        'summary'           => $this->getSummary(),
        'totalGlobalRab'    => $this->getSummary()['bahan']['total'] + $this->getSummary()['operasional']['total'] + $this->getSummary()['insentif']['total'],
        'listAnggaranBahan' => AnggaranBahan::where('dapur_id', $user->dapur_id)->latest()->get(),
        // Ambil data dari tabel kategori penerima kamu
        'kategoriPenerima'  => DB::table('kategori_penerima')->get(), 
    ]);
    }

}