<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanStokExport implements FromArray, WithHeadings
{
    protected $items;

    public function __construct($items)
    {
        $this->items = $items;
    }

    public function headings(): array
    {
        return [
            'Nama Barang',
            'Satuan',
            'Saldo Awal',
            'Masuk',
            'Keluar',
            'Saldo Akhir',
            'Harga Beli',
            'Jumlah',
        ];
    }

    public function array(): array
    {
        return collect($this->items)->map(function ($item) {
            return [
                $item['nama_barang'],
                $item['satuan'],
                $item['saldo_awal'],
                $item['masuk'],
                $item['keluar'],
                $item['saldo_akhir'],
                $item['harga_beli'],
                $item['jumlah_nilai'],
            ];
        })->toArray();
    }
}