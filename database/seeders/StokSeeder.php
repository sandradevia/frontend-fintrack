<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Barang;
use App\Models\StokAwal;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dapurId = 5; // sesuaikan

        $barangList = [
            ['nama' => 'Beras premium', 'satuan' => 'kg', 'stok' => 12, 'harga' => 15000],
            ['nama' => 'Beras jagung', 'satuan' => 'kg', 'stok' => 8, 'harga' => 17000],
            ['nama' => 'Tepung terigu', 'satuan' => 'kg', 'stok' => 7, 'harga' => 14000],
            ['nama' => 'Roti gandum', 'satuan' => 'kg', 'stok' => 15, 'harga' => 15000],
            ['nama' => 'Biskuit', 'satuan' => 'pcs', 'stok' => 5, 'harga' => 7500],
            ['nama' => 'Bubur bayi', 'satuan' => 'pcs', 'stok' => 4, 'harga' => 5000],
            ['nama' => 'Kentang', 'satuan' => 'kg', 'stok' => 5, 'harga' => 7000],
            ['nama' => 'Daging sapi', 'satuan' => 'kg', 'stok' => 10, 'harga' => 100000],
            ['nama' => 'Daging ayam', 'satuan' => 'kg', 'stok' => 5, 'harga' => 30000],
            ['nama' => 'Sosis sapi', 'satuan' => 'pak', 'stok' => 7, 'harga' => 40000],
            ['nama' => 'Sosis ayam', 'satuan' => 'pak', 'stok' => 6, 'harga' => 25000],
            ['nama' => 'Ikan tongkol', 'satuan' => 'kg', 'stok' => 4, 'harga' => 35000],
            ['nama' => 'Ikan sarden', 'satuan' => 'kg', 'stok' => 5, 'harga' => 60000],
            ['nama' => 'Udang', 'satuan' => 'kg', 'stok' => 5, 'harga' => 70000],
            ['nama' => 'Cumi', 'satuan' => 'kg', 'stok' => 9, 'harga' => 30000],
            ['nama' => 'Telur ayam', 'satuan' => 'kg', 'stok' => 10, 'harga' => 32000],
            ['nama' => 'Susu bubuk/UHT', 'satuan' => 'kg/ltr', 'stok' => 5, 'harga' => 50000],
            ['nama' => 'Susu ibu hamil', 'satuan' => 'ltr', 'stok' => 23, 'harga' => 70000],
            ['nama' => 'Keju', 'satuan' => 'kg', 'stok' => 18, 'harga' => 30000],
            ['nama' => 'Kacang hijau', 'satuan' => 'kg', 'stok' => 17, 'harga' => 20000],
            ['nama' => 'Kacang merah', 'satuan' => 'kg', 'stok' => 9, 'harga' => 20000],
            ['nama' => 'Tempe', 'satuan' => 'papan', 'stok' => 3, 'harga' => 15000],
            ['nama' => 'Tahu', 'satuan' => 'kg', 'stok' => 2, 'harga' => 20000],
            ['nama' => 'Minyak goreng', 'satuan' => 'ltr', 'stok' => 9, 'harga' => 16000],
            ['nama' => 'Telur puyuh', 'satuan' => 'kg', 'stok' => 5, 'harga' => 22000],
            ['nama' => 'Aqua galon', 'satuan' => 'galon', 'stok' => 0, 'harga' => 0],
            ['nama' => 'Aqua botol 600 ml', 'satuan' => 'dus', 'stok' => 0, 'harga' => 0],
            ['nama' => 'Aqua cup', 'satuan' => 'dus', 'stok' => 0, 'harga' => 0],
        ];

        foreach ($barangList as $item) {

            $barang = Barang::firstOrCreate(
                [
                    'dapur_id' => $dapurId,
                    'nama_barang' => $item['nama'],
                ],
                [
                    'satuan' => $item['satuan'],
                    'supplier' => 'Supplier Umum',
                ]
            );

            StokAwal::updateOrCreate(
                [
                    'barang_id' => $barang->id,
                    'dapur_id' => $dapurId,
                ],
                [
                    'jumlah' => $item['stok'],
                    'harga_beli_awal' => $item['harga'],
                ]
            );
        }
    }
}
