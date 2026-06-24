<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SaldoAwalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua akun
        $akun = DB::table('akun')->pluck('id', 'kode');

        $data = [
            // ============================================
            // DAPUR 1 - PERIODE 2 (2026-06-08 s/d 2026-06-19) - TIDAK AKTIF
            // Saldo awal = hasil akumulasi transaksi Mei
            // ============================================
            ['periode_id' => 2, 'akun_id' => $akun['1101'], 'saldo_awal' => 5000000],
            ['periode_id' => 2, 'akun_id' => $akun['1102'], 'saldo_awal' => 374208000],
            ['periode_id' => 2, 'akun_id' => $akun['2110'], 'saldo_awal' => 301316000],
            ['periode_id' => 2, 'akun_id' => $akun['2120'], 'saldo_awal' => 76592000],
            ['periode_id' => 2, 'akun_id' => $akun['2130'], 'saldo_awal' => 0],
            ['periode_id' => 2, 'akun_id' => $akun['3110'], 'saldo_awal' => 49650000],
            ['periode_id' => 2, 'akun_id' => $akun['3120'], 'saldo_awal' => 34000000],
            ['periode_id' => 2, 'akun_id' => $akun['3130'], 'saldo_awal' => 72000000],

            // ============================================
            // DAPUR 1 - PERIODE 3 (2026-06-22 s/d 2026-07-03) - AKTIF
            // Saldo awal = hasil akumulasi transaksi s/d periode 2
            // ============================================
            ['periode_id' => 3, 'akun_id' => $akun['1101'], 'saldo_awal' => 5000000],
            ['periode_id' => 3, 'akun_id' => $akun['1102'], 'saldo_awal' => 379208000],
            ['periode_id' => 3, 'akun_id' => $akun['2110'], 'saldo_awal' => 242816000],
            ['periode_id' => 3, 'akun_id' => $akun['2120'], 'saldo_awal' => 54042000],
            ['periode_id' => 3, 'akun_id' => $akun['2130'], 'saldo_awal' => 0],
            ['periode_id' => 3, 'akun_id' => $akun['3110'], 'saldo_awal' => 57650000],
            ['periode_id' => 3, 'akun_id' => $akun['3120'], 'saldo_awal' => 56542000],
            ['periode_id' => 3, 'akun_id' => $akun['3130'], 'saldo_awal' => 72000000],

            // ============================================
            // DAPUR 5 - PERIODE 8 (2025-12-29 s/d 2026-01-09) - TIDAK AKTIF
            // ============================================
            ['periode_id' => 8, 'akun_id' => $akun['1101'], 'saldo_awal' => 2000000],
            ['periode_id' => 8, 'akun_id' => $akun['1102'], 'saldo_awal' => 8000000],
            ['periode_id' => 8, 'akun_id' => $akun['2110'], 'saldo_awal' => 3500000],
            ['periode_id' => 8, 'akun_id' => $akun['2120'], 'saldo_awal' => 6500000],
            ['periode_id' => 8, 'akun_id' => $akun['2130'], 'saldo_awal' => 0],
            ['periode_id' => 8, 'akun_id' => $akun['3110'], 'saldo_awal' => 0],
            ['periode_id' => 8, 'akun_id' => $akun['3120'], 'saldo_awal' => 0],
            ['periode_id' => 8, 'akun_id' => $akun['3130'], 'saldo_awal' => 0],

            // ============================================
            // DAPUR 5 - PERIODE 9 (2026-06-01 s/d 2026-06-13) - TIDAK AKTIF
            // ============================================
            ['periode_id' => 9, 'akun_id' => $akun['1101'], 'saldo_awal' => 2000000],
            ['periode_id' => 9, 'akun_id' => $akun['2110'], 'saldo_awal' => 3500000],
            ['periode_id' => 9, 'akun_id' => $akun['2120'], 'saldo_awal' => 6500000],
            ['periode_id' => 9, 'akun_id' => $akun['2130'], 'saldo_awal' => 0],
            ['periode_id' => 9, 'akun_id' => $akun['3110'], 'saldo_awal' => 0],
            ['periode_id' => 9, 'akun_id' => $akun['3120'], 'saldo_awal' => 0],
            ['periode_id' => 9, 'akun_id' => $akun['3130'], 'saldo_awal' => 0],

            // ============================================
            // DAPUR 5 - PERIODE 10 (2026-06-15 s/d 2026-06-27) - AKTIF
            // Ini yang muncul di gambar (10jt, 2jt, 8jt, 3.5jt, 6.5jt)
            // ============================================
            ['periode_id' => 10, 'akun_id' => $akun['1101'], 'saldo_awal' => 2000000],
            ['periode_id' => 10, 'akun_id' => $akun['1102'], 'saldo_awal' => 8000000],
            ['periode_id' => 10, 'akun_id' => $akun['2110'], 'saldo_awal' => 3500000],
            ['periode_id' => 10, 'akun_id' => $akun['2120'], 'saldo_awal' => 6500000],
            ['periode_id' => 10, 'akun_id' => $akun['2130'], 'saldo_awal' => 0],
            ['periode_id' => 10, 'akun_id' => $akun['3110'], 'saldo_awal' => 0],
            ['periode_id' => 10, 'akun_id' => $akun['3120'], 'saldo_awal' => 0],
            ['periode_id' => 10, 'akun_id' => $akun['3130'], 'saldo_awal' => 0],
        ];

        DB::table('saldo_awal_buku')->insert($data);
    }

}
