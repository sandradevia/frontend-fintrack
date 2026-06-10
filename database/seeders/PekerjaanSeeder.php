<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PekerjaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pekerjaans')->insert([
            ['id' => 1, 'nama_pekerjaan' => 'Asisten Lapangan'],
            ['id' => 2, 'nama_pekerjaan' => 'Persiapan Bahan Makanan'],
            ['id' => 3, 'nama_pekerjaan' => 'Pengolahan Bahan Makanan (Bagian Memasak)'],
            ['id' => 4, 'nama_pekerjaan' => 'Pemorsian'],
            ['id' => 5, 'nama_pekerjaan' => 'Distribusi'],
            ['id' => 6, 'nama_pekerjaan' => 'Keamanan'],
            ['id' => 7, 'nama_pekerjaan' => 'Petugas Kebersihan'],
            ['id' => 8, 'nama_pekerjaan' => 'Pencuci Alat Makan'],
        ]);;
    }
}
