<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AkunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('akun')->insert([
            ['kode' => '1000', 'nama_akun' => 'BUKU KAS UMUM'],

            ['kode' => '1100', 'nama_akun' => 'BUKU PEMBANTU KAS'],
            ['kode' => '1101', 'nama_akun' => 'Petty Cash / Cash in Hand'],
            ['kode' => '1102', 'nama_akun' => 'Kas di Bank'],

            ['kode' => '2000', 'nama_akun' => 'BUKU PEMBANTU JENIS DANA'],
            ['kode' => '2110', 'nama_akun' => 'Dana Bahan Baku'],
            ['kode' => '2120', 'nama_akun' => 'Dana Operasional'],
            ['kode' => '2130', 'nama_akun' => 'Dana Insentif Fasilitas'],
            ['kode' => '2140', 'nama_akun' => 'Pungutan/Setoran PPN'],
            ['kode' => '2150', 'nama_akun' => 'Pungutan/Setoran PPh 21'],
            ['kode' => '2160', 'nama_akun' => 'Pungutan/Setoran PPh 22'],
            ['kode' => '2170', 'nama_akun' => 'Pungutan/Setoran PPh 23'],
            ['kode' => '2180', 'nama_akun' => 'Pungutan/Setoran PPh Pasal 4 Ayat (2)'],

            ['kode' => '3000', 'nama_akun' => 'BUKU PEMBANTU BIAYA'],
            ['kode' => '3110', 'nama_akun' => 'Biaya Bahan Baku'],
            ['kode' => '3120', 'nama_akun' => 'Biaya Operasional'],
            ['kode' => '3130', 'nama_akun' => 'Biaya Insentif Fasilitas'],
        ]);
    }
}
