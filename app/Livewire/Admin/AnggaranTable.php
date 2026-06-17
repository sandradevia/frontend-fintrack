<?php

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
    // Disinkronkan ke query string ?tab=..., jadi bisa di-refresh / di-bookmark
    #[Url(as: 'tab')]
    public $activeTab = 'bahan';

    // Modal
    public $showModalTambah = false;

    // Form
    public $kategoriAnggaran = '';

    public $tanggal;
    public $harga_satuan;
    public $total_rab;
    public $keterangan;

    public $anggaran_bahan_id;

    // Detail penerima
    public $kb_tk = 0;
    public $sd_1_3 = 0;
    public $sd_4_6 = 0;
    public $smp = 0;
    public $sma = 0;
    public $balita = 0;
    public $bumil = 0;
    public $busui = 0;

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function getJumlahPaketProperty()
    {
        return
            (int) $this->kb_tk +
            (int) $this->sd_1_3 +
            (int) $this->sd_4_6 +
            (int) $this->smp +
            (int) $this->sma +
            (int) $this->balita +
            (int) $this->bumil +
            (int) $this->busui;
    }

    public function getTotalRabProperty()
    {
        return $this->jumlahPaket * ($this->harga_satuan ?? 0);
    }

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
            'total_rab',
            'keterangan',
            'anggaran_bahan_id',

            'kb_tk',
            'sd_1_3',
            'sd_4_6',
            'smp',
            'sma',
            'balita',
            'bumil',
            'busui',
        ]);
    }

    private function simpanBahan()
    {
        $this->validate([
            'tanggal' => 'required|date',
            'harga_satuan' => 'required|numeric|min:1',
        ]);

        DB::transaction(function () {

            $anggaran = AnggaranBahan::create([
                'dapur_id'      => Auth::user()->dapur_id,
                'tanggal'       => $this->tanggal,
                'jumlah_paket'  => $this->jumlahPaket,
                'harga_satuan'  => $this->harga_satuan,
                'total_rab'     => $this->totalRab,
            ]);

            $detail = [
                1 => $this->kb_tk,
                2 => $this->sd_1_3,
                3 => $this->sd_4_6,
                4 => $this->smp,
                5 => $this->sma,
                6 => $this->balita,
                7 => $this->bumil,
                8 => $this->busui,
            ];

            foreach ($detail as $kategoriId => $jumlah) {

                if ($jumlah > 0) {

                    DetailAnggaranBahan::create([
                        'anggaran_bahan_id'     => $anggaran->id,
                        'kategori_penerima_id' => $kategoriId,
                        'jumlah'               => $jumlah,
                    ]);
                }
            }
        });
    }

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
        $summary = $this->getSummary();

        return view('livewire.admin.anggaran-table', [
            'items'   => $this->getData(),
            'summary' => $summary,
            'totalGlobalRab' =>
                $summary['bahan']['total'] +
                $summary['operasional']['total'] +
                $summary['insentif']['total'],
            'listAnggaranBahan' => AnggaranBahan::where(
                'dapur_id',
                $user->dapur_id
            )->latest()->get(),
        ]);
    }
}