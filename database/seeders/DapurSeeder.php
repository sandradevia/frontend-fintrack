<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DapurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('dapur')->insert([
            [
                'id' => 1,
                'nama_lembaga' => 'Dapur Utama',
                'alamat' => 'Jl. Contoh No.1',
                'nama_kepala_sppg' => 'Budi',
                'nama_akuntan' => 'Siti',
                'nama_yayasan' => 'Yayasan Contoh',
                'ketua_yayasan' => 'Andi',
                'nomor_rekening' => '1234567890',
                'tempat_pelaporan' => 'Jakarta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'nama_lembaga' => 'Dapur Cabang',
                'alamat' => 'Jl. Contoh No.2',
                'nama_kepala_sppg' => 'Sari',
                'nama_akuntan' => 'Rina',
                'nama_yayasan' => 'Yayasan Contoh',
                'ketua_yayasan' => 'Andi',
                'nomor_rekening' => '0987654321',
                'tempat_pelaporan' => 'Bandung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
