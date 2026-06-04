<?php

namespace Database\Seeders;

use App\Models\Dapur;
use Illuminate\Database\Seeder;

class DapurSeeder extends Seeder
{
    public function run(): void
    {
        Dapur::create([
            'nama_lembaga' => 'Dapur Utama',
            'alamat' => 'Jl. Contoh 1',
            'nama_kepala_sppg' => 'Budi',
            'nama_akuntan' => 'Siti',
            'nama_yayasan' => 'Yayasan A',
            'ketua_yayasan' => 'Andi',
            'nomor_rekening' => '123',
        ]);

        Dapur::create([
            'nama_lembaga' => 'Dapur Cabang',
            'alamat' => 'Jl. Contoh 2',
            'nama_kepala_sppg' => 'Sari',
            'nama_akuntan' => 'Rina',
            'nama_yayasan' => 'Yayasan B',
            'ketua_yayasan' => 'Andi',
            'nomor_rekening' => '456',
        ]);
    }
}