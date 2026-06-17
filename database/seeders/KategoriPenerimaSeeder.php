<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriPenerimaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategori = [
            ['id' => 1, 'created_at' => now(), 'updated_at' => now(), 'nama_kategori' => 'KB / TK'],
            ['id' => 2, 'created_at' => now(), 'updated_at' => now(), 'nama_kategori' => 'SD Kelas 1-3'],
            ['id' => 3, 'created_at' => now(), 'updated_at' => now(), 'nama_kategori' => 'SD Kelas 4-6'],
            ['id' => 4, 'created_at' => now(), 'updated_at' => now(), 'nama_kategori' => 'SMP'],
            ['id' => 5, 'created_at' => now(), 'updated_at' => now(), 'nama_kategori' => 'SMA'],
            ['id' => 6, 'created_at' => now(), 'updated_at' => now(), 'nama_kategori' => 'Balita'],
            ['id' => 7, 'created_at' => now(), 'updated_at' => now(), 'nama_kategori' => 'Ibu Hamil'],
            ['id' => 8, 'created_at' => now(), 'updated_at' => now(), 'nama_kategori' => 'Ibu Menyusui'],
        ];

        DB::table('kategori_penerima')->insert($kategori);
    }
}
