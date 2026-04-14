<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('transaksis')->insert([
            ['id'=>1,'dapur_id'=>1,'tanggal'=>'2025-01-01','no_bukti'=>'TRX001','uraian'=>'Pembelian beras'],
            ['id'=>2,'dapur_id'=>2,'tanggal'=>'2025-01-02','no_bukti'=>'TRX002','uraian'=>'Pembelian minyak'],
        ]);
    }
}
