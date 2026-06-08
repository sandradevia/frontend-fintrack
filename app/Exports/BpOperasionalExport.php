<?php

namespace App\Exports;

use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BpOperasionalExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $user = Auth::user();

        return Transaksi::where('dapur_id', $user->dapur_id)
            ->whereHas('akun', function ($q) {
                $q->where('nama_akun', 'Dana Operasional')
                  ->orWhere('nama_akun', 'Biaya Operasional');
            })
            ->select(
                'tanggal',
                'no_bukti',
                'uraian',
                'debet',
                'kredit'
            )
            ->get();
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'No Bukti',
            'Uraian',
            'Debet',
            'Kredit',
        ];
    }
}