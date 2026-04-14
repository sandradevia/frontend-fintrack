<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('barang')->insert([
            ['id'=>1,'nama_barang'=>'Beras','supplier'=>'A','satuan'=>'kg','dapur_id'=>1],
            ['id'=>2,'nama_barang'=>'Minyak','supplier'=>'B','satuan'=>'liter','dapur_id'=>2],
        ]);
    }
}
