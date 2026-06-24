<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Akun;
use App\Models\Transaksi;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [

            /*
            |--------------------------------------------------------------------------
            | DAPUR 1
            | 18 - 30 MEI 2026
            |--------------------------------------------------------------------------
            */

            [
                'dapur_id' => 1,
                'tanggal' => '2026-05-18',
                'uraian' => 'Menerima bantuan pemerintah untuk bahan baku',
                'debet' => 342816000,
                'kredit' => 0,
            ],
            [
                'dapur_id' => 1,
                'tanggal' => '2026-05-18',
                'uraian' => 'Menerima bantuan pemerintah untuk operasional',
                'debet' => 110592000,
                'kredit' => 0,
            ],
            [
                'dapur_id' => 1,
                'tanggal' => '2026-05-18',
                'uraian' => 'Menerima bantuan pemerintah untuk insentif fasilitas',
                'debet' => 72000000,
                'kredit' => 0,
            ],
            [
                'dapur_id' => 1,
                'tanggal' => '2026-05-19',
                'uraian' => 'Membayar belanja beras dan minyak goreng',
                'debet' => 0,
                'kredit' => 26500000,
            ],
            [
                'dapur_id' => 1,
                'tanggal' => '2026-05-20',
                'uraian' => 'Membayar belanja daging sapi dan sayuran',
                'debet' => 0,
                'kredit' => 15000000,
            ],
            [
                'dapur_id' => 1,
                'tanggal' => '2026-05-21',
                'uraian' => 'Pengambilan petty cash',
                'debet' => 5000000,
                'kredit' => 0,
            ],
            [
                'dapur_id' => 1,
                'tanggal' => '2026-05-22',
                'uraian' => 'Pembelian minuman kemasan',
                'debet' => 0,
                'kredit' => 6150000,
            ],
            [
                'dapur_id' => 1,
                'tanggal' => '2026-05-23',
                'uraian' => 'Pembayaran listrik',
                'debet' => 0,
                'kredit' => 1500000,
            ],
            [
                'dapur_id' => 1,
                'tanggal' => '2026-05-24',
                'uraian' => 'Pembelian buah-buahan',
                'debet' => 0,
                'kredit' => 2150000,
            ],
            [
                'dapur_id' => 1,
                'tanggal' => '2026-05-25',
                'uraian' => 'Pembayaran air tangki',
                'debet' => 0,
                'kredit' => 2000000,
            ],
            [
                'dapur_id' => 1,
                'tanggal' => '2026-05-26',
                'uraian' => 'Pembayaran BBM kendaraan operasional',
                'debet' => 0,
                'kredit' => 500000,
            ],
            [
                'dapur_id' => 1,
                'tanggal' => '2026-05-27',
                'uraian' => 'Pembelian plastik dan mika',
                'debet' => 0,
                'kredit' => 400000,
            ],
            [
                'dapur_id' => 1,
                'tanggal' => '2026-05-28',
                'uraian' => 'Pembayaran insentif fasilitas 2 pekan',
                'debet' => 0,
                'kredit' => 72000000,
            ],
            [
                'dapur_id' => 1,
                'tanggal' => '2026-05-29',
                'uraian' => 'Pembayaran honor relawan',
                'debet' => 0,
                'kredit' => 30000000,
            ],

            /*
            |--------------------------------------------------------------------------
            | DAPUR 1
            | 1 - 13 JUNI 2026
            |--------------------------------------------------------------------------
            */

            [
                'dapur_id' => 1,
                'tanggal' => '2026-06-01',
                'uraian' => 'Penerimaan dana bahan baku tahap 2',
                'debet' => 342816000,
                'kredit' => 0,
            ],
            [
                'dapur_id' => 1,
                'tanggal' => '2026-06-01',
                'uraian' => 'Penerimaan dana operasional tahap 2',
                'debet' => 110592000,
                'kredit' => 0,
            ],
            [
                'dapur_id' => 1,
                'tanggal' => '2026-06-02',
                'uraian' => 'Belanja bahan baku mingguan',
                'debet' => 0,
                'kredit' => 24000000,
            ],
            [
                'dapur_id' => 1,
                'tanggal' => '2026-06-03',
                'uraian' => 'Belanja sayur dan buah',
                'debet' => 0,
                'kredit' => 4500000,
            ],
            [
                'dapur_id' => 1,
                'tanggal' => '2026-06-04',
                'uraian' => 'Belanja daging dan telur',
                'debet' => 0,
                'kredit' => 17000000,
            ],
            [
                'dapur_id' => 1,
                'tanggal' => '2026-06-05',
                'uraian' => 'Pembayaran listrik',
                'debet' => 0,
                'kredit' => 1800000,
            ],
            [
                'dapur_id' => 1,
                'tanggal' => '2026-06-06',
                'uraian' => 'Pembayaran air',
                'debet' => 0,
                'kredit' => 2000000,
            ],
            [
                'dapur_id' => 1,
                'tanggal' => '2026-06-07',
                'uraian' => 'Pembelian gas LPG',
                'debet' => 0,
                'kredit' => 3500000,
            ],
            [
                'dapur_id' => 1,
                'tanggal' => '2026-06-08',
                'uraian' => 'Pembayaran relawan',
                'debet' => 0,
                'kredit' => 15000000,
            ],
            [
                'dapur_id' => 1,
                'tanggal' => '2026-06-09',
                'uraian' => 'Pembelian perlengkapan dapur',
                'debet' => 0,
                'kredit' => 2500000,
            ],
            [
                'dapur_id' => 1,
                'tanggal' => '2026-06-10',
                'uraian' => 'Pembelian bahan baku tambahan',
                'debet' => 0,
                'kredit' => 8000000,
            ],
            [
                'dapur_id' => 1,
                'tanggal' => '2026-06-11',
                'uraian' => 'Belanja susu dan makanan tambahan',
                'debet' => 0,
                'kredit' => 6000000,
            ],
            [
                'dapur_id' => 1,
                'tanggal' => '2026-06-12',
                'uraian' => 'Pembayaran BBM operasional',
                'debet' => 0,
                'kredit' => 750000,
            ],
            [
                'dapur_id' => 1,
                'tanggal' => '2026-06-13',
                'uraian' => 'Pembayaran insentif relawan',
                'debet' => 0,
                'kredit' => 18000000,
            ],
        ];

        /*
        |--------------------------------------------------------------------------
        | DAPUR 5
        | 18 - 30 MEI 2026
        |--------------------------------------------------------------------------
        */

        $tanggal = [
            '2026-05-18','2026-05-19','2026-05-20','2026-05-21',
            '2026-05-22','2026-05-23','2026-05-24','2026-05-25',
            '2026-05-26','2026-05-27','2026-05-28','2026-05-29',
            '2026-05-30'
        ];

        foreach ($tanggal as $i => $tgl) {
            $data[] = [
                'dapur_id' => 5,
                'tanggal' => $tgl,
                'uraian' => 'Belanja operasional dapur hari ke-'.($i + 1),
                'debet' => 0,
                'kredit' => rand(1000000, 6000000),
            ];

            $data[] = [
                'dapur_id' => 5,
                'tanggal' => $tgl,
                'uraian' => 'Penerimaan dana bantuan hari ke-'.($i + 1),
                'debet' => rand(5000000, 20000000),
                'kredit' => 0,
            ];
        }

        foreach ($data as $index => $item) {

            Transaksi::create([
                'dapur_id' => $item['dapur_id'],
                'akun_id' => 1, // sesuaikan dengan akun yang ada
                'tanggal' => $item['tanggal'],
                'no_bukti' => 'TRX-' . str_pad($index + 1, 5, '0', STR_PAD_LEFT),
                'uraian' => $item['uraian'],
                'debet' => $item['debet'],
                'kredit' => $item['kredit'],
                'keterangan' => 'Seeder transaksi',
            ]);
        }
    }
}
