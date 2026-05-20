<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Dapur;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dapur = Dapur::first();

DB::table('barang')->insert([
    [
        'nama_barang' => 'Beras',
        'satuan' => 'kg',
        'supplier' => 'Makmur',
        'dapur_id' => $dapur->id,
    ]
]);
    }
}
