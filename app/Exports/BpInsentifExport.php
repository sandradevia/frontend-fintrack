<?php

namespace App\Exports;

use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BpInsentifExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $user = Auth::user();

        return Transaksi::with('akun')
            ->where('dapur_id', $user->dapur_id)
            ->whereHas('akun', function ($q) {
                $q->where('nama_akun', 'Dana Insentif Fasilitas')
                  ->orWhere('nama_akun', 'Biaya Insentif Fasilitas');
            })
            ->get([
                'tanggal',
                'no_bukti',
                'uraian',
                'debet',
                'kredit',
            ]);
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