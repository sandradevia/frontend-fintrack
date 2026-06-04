<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CatatanPengeluaranExport implements FromArray, WithHeadings
{
    protected $transaksis;

    public function __construct($transaksis)
    {
        $this->transaksis = $transaksis;
    }

    public function headings(): array
    {
        return [
            'Bulan',
            'Tanggal',
            'No Bukti',
            'Uraian Transaksi',
            'Kategori',
            'Jumlah',
        ];
    }

    public function array(): array
    {
        return $this->transaksis->map(function ($item) {
            return [
                \Carbon\Carbon::parse($item->tanggal)->translatedFormat('F'),
                \Carbon\Carbon::parse($item->tanggal)->format('d'),
                $item->no_bukti,
                $item->uraian,
                $item->akun->nama_akun ?? '-',
                $item->kredit,
            ];
        })->toArray();
    }
}