<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnggaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // anggaran bahan
        DB::table('anggaran_bahan')->insert([
            ['id'=>1,'dapur_id'=>1,'tanggal'=>'2025-01-01','jumlah_paket'=>100,'harga_satuan'=>10000,'total_rab'=>1000000],
            ['id'=>2,'dapur_id'=>2,'tanggal'=>'2025-01-01','jumlah_paket'=>50,'harga_satuan'=>12000,'total_rab'=>600000],
        ]);

        // detail
        DB::table('detail_anggaran_bahan')->insert([
            ['id'=>1,'anggaran_bahan_id'=>1,'kategori'=>'SD','jumlah'=>60],
            ['id'=>2,'anggaran_bahan_id'=>2,'kategori'=>'SMP','jumlah'=>40],
        ]);

        // operasional
        DB::table('anggaran_operasional')->insert([
            ['dapur_id'=>1,'tanggal'=>'2025-01-01','total_rab'=>500000],
            ['dapur_id'=>2,'tanggal'=>'2025-01-01','total_rab'=>300000],
        ]);

        // insentif
        DB::table('anggaran_insentif')->insert([
            ['id'=>1,'dapur_id'=>1,'anggaran_bahan_id'=>1,'tanggal'=>'2025-01-01','harga_satuan'=>50000,'total_rab'=>200000],
            ['id'=>2,'dapur_id'=>2,'anggaran_bahan_id'=>2,'tanggal'=>'2025-01-01','harga_satuan'=>60000,'total_rab'=>240000],
        ]);
    }
}
