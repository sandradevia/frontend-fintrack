<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class AnggaranTable extends Component
{
    public $activeTab = 'bahan';

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        // Ambil data berdasarkan tab yang aktif
        $items = $this->getData();

        return view('livewire.admin.anggaran-table', [
            'items' => $items
        ]);
    }

    private function getData()
    {
        // Simulasi data - Nanti ganti dengan Anggaran::where(...)->get()
        if ($this->activeTab === 'bahan') {
            return [
                ['id' => 1, 'tanggal' => '2024-03-01', 'jumlah' => 100, 'harga' => 15000],
            ];
        } 
        
        if ($this->activeTab === 'operasional') {
            return [
                ['id' => 1, 'nama' => 'Listrik', 'kat' => 'Utilitas', 'nom' => 500000],
            ];
        }

        return [];
    }
}