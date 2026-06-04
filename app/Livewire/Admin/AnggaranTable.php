<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\AnggaranBahan;
use App\Models\AnggaranOperasional;
use App\Models\AnggaranInsentif;

class AnggaranTable extends Component
{
    public $activeTab = 'bahan';

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        return view('livewire.admin.anggaran-table', [
            'items' => $this->getData()
        ]);
    }

    private function getData()
    {
        if ($this->activeTab === 'bahan') {

            return AnggaranBahan::with([
                'dapur',
                'details'
            ])->get();
        }

        if ($this->activeTab === 'operasional') {

            return AnggaranOperasional::with([
                'dapur'
            ])->get();
        }

        if ($this->activeTab === 'insentif') {

            return AnggaranInsentif::with([
                'dapur',
                'bahan'
            ])->get();
        }

        return collect();
    }
}