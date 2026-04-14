<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('stok_awal')->insert([
            ['barang_id'=>1,'dapur_id'=>1,'jumlah'=>100],
            ['barang_id'=>2,'dapur_id'=>2,'jumlah'=>50],
        ]);

        DB::table('stok_barang')->insert([
            ['barang_id'=>1,'dapur_id'=>1,'stok'=>100],
            ['barang_id'=>2,'dapur_id'=>2,'stok'=>50],
        ]);
    }
}
