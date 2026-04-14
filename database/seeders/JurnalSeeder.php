<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JurnalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jurnal')->insert([
            ['transaksi_id'=>1,'akun_id'=>1,'debit'=>100000,'kredit'=>0],
            ['transaksi_id'=>1,'akun_id'=>2,'debit'=>0,'kredit'=>100000],

            ['transaksi_id'=>2,'akun_id'=>1,'debit'=>200000,'kredit'=>0],
            ['transaksi_id'=>2,'akun_id'=>2,'debit'=>0,'kredit'=>200000],
        ]);
    }
}
