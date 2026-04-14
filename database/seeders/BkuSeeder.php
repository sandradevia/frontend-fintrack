<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BkuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bku')->insert([
            ['dapur_id'=>1,'transaksi_id'=>1,'tanggal'=>'2025-01-01','no_bukti'=>'BKU001'],
            ['dapur_id'=>2,'transaksi_id'=>2,'tanggal'=>'2025-01-02','no_bukti'=>'BKU002'],
        ]);
    }
}
