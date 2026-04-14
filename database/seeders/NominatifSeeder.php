<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NominatifSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('daftar_nominatif')->insert([
        [
            'dapur_id'=>1,
            'anggota_id'=>1,
            'tanggal'=>'2025-01-01',
            'no_bukti'=>'NM001',
            'honor'=>100000,
            'dana_sehat'=>10000,
            'transport'=>15000,
            'pajak'=>5000,
            'total'=>120000
        ],
        [
            'dapur_id'=>2,
            'anggota_id'=>2,
            'tanggal'=>'2025-01-01',
            'no_bukti'=>'NM002',
            'honor'=>120000,
            'dana_sehat'=>15000,
            'transport'=>10000,
            'pajak'=>5000,
            'total'=>140000
        ],
    ]);
    }
}
