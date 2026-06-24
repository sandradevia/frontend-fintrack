<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Barang;
use App\Models\StokBarang;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dapurId = 5; // sesuaikan dengan ID dapur yang sudah ada

        $barangList = [
            ['nama' => 'Beras premium', 'satuan' => 'kg', 'stok' => 12],
            ['nama' => 'Beras jagung', 'satuan' => 'kg', 'stok' => 8],
            ['nama' => 'Tepung terigu', 'satuan' => 'kg', 'stok' => 7],
            ['nama' => 'Roti gandum', 'satuan' => 'kg', 'stok' => 15],
            ['nama' => 'Biskuit', 'satuan' => 'pcs', 'stok' => 5],
            ['nama' => 'Bubur bayi', 'satuan' => 'pcs', 'stok' => 4],
            ['nama' => 'Kentang', 'satuan' => 'kg', 'stok' => 5],
            ['nama' => 'Daging sapi', 'satuan' => 'kg', 'stok' => 10],
            ['nama' => 'Daging ayam', 'satuan' => 'kg', 'stok' => 5],
            ['nama' => 'Sosis sapi', 'satuan' => 'pak', 'stok' => 7],
            ['nama' => 'Sosis ayam', 'satuan' => 'pak', 'stok' => 6],
            ['nama' => 'Ikan tongkol', 'satuan' => 'kg', 'stok' => 4],
            ['nama' => 'Ikan sarden', 'satuan' => 'kg', 'stok' => 5],
            ['nama' => 'Udang', 'satuan' => 'kg', 'stok' => 5],
            ['nama' => 'Cumi', 'satuan' => 'kg', 'stok' => 9],
            ['nama' => 'Telur ayam', 'satuan' => 'kg', 'stok' => 10],
            ['nama' => 'Susu bubuk/UHT', 'satuan' => 'kg/ltr', 'stok' => 5],
            ['nama' => 'Susu ibu hamil', 'satuan' => 'ltr', 'stok' => 23],
            ['nama' => 'Keju', 'satuan' => 'kg', 'stok' => 18],
            ['nama' => 'Kacang hijau', 'satuan' => 'kg', 'stok' => 17],
            ['nama' => 'Kacang merah', 'satuan' => 'kg', 'stok' => 9],
            ['nama' => 'Tempe', 'satuan' => 'papan', 'stok' => 3],
            ['nama' => 'Tahu', 'satuan' => 'kg', 'stok' => 2],
            ['nama' => 'Minyak goreng', 'satuan' => 'ltr', 'stok' => 9],
            ['nama' => 'Telur puyuh', 'satuan' => 'kg', 'stok' => 5],
            ['nama' => 'Aqua galon', 'satuan' => 'galon', 'stok' => 0],
            ['nama' => 'Aqua botol 600 ml', 'satuan' => 'dus', 'stok' => 0],
            ['nama' => 'Aqua cup', 'satuan' => 'dus', 'stok' => 0],
        ];

        foreach ($barangList as $item) {
            $barang = Barang::create([
                'dapur_id' => $dapurId,
                'nama_barang' => $item['nama'],
                'satuan' => $item['satuan'],
                'supplier' => 'Supplier Umum',
            ]);

            StokBarang::create([
                'barang_id' => $barang->id,
                'dapur_id' => $dapurId,
                'stok' => $item['stok'],
            ]);
        }
    }
}
