<?php

namespace App\Exports;

use App\Models\DaftarNominatif;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DaftarNominatifExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $dapurId;

    public function __construct($dapurId)
    {
        $this->dapurId = $dapurId;
    }

    public function collection()
    {
        return DaftarNominatif::with('anggota')
            ->where('dapur_id', $this->dapurId)
            ->get()
            ->map(function ($item) {
                return [
                    'Tanggal'      => $item->tanggal,
                    'No Bukti'     => $item->no_bukti,
                    'Nama'         => $item->anggota->nama ?? '-',
                    'Honor'        => $item->honor,
                    'Dana Sehat'   => $item->dana_sehat,
                    'Transport'    => $item->transport,
                    'Pajak'        => $item->pajak,
                    'Total'        => $item->total,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'No Bukti',
            'Nama',
            'Honor',
            'Dana Sehat',
            'Transport',
            'Pajak',
            'Total',
        ];
    }
}