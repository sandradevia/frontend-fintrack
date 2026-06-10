<?php

namespace Database\Seeders;

use App\Models\Dapur;
use Illuminate\Database\Seeder;

class DapurSeeder extends Seeder
{
    public function run(): void
    {
        Dapur::create([
            'nama_lembaga' => 'SPPG GADOG MEGAMENDUNG',
            'alamat' => 'Jl. Pasir Angin desa Gadog',
            'nama_kepala_sppg' => 'Sutiono',
            'nama_akuntan' => 'Riyanto',
            'nama_yayasan' => 'Yayasan Bakti Nusa',
            'ketua_yayasan' => 'Bakri',
            'nomor_rekening' => '123456',
        ]);
    }
}