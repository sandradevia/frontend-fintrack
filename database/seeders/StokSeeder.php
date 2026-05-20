<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $dapur1 = DB::table('dapur')->first();
    $dapur2 = DB::table('dapur')->skip(1)->first();

    $barang1 = DB::table('barang')->first();
    $barang2 = DB::table('barang')->skip(1)->first();

    if (!$dapur1 || !$barang1) {
        throw new \Exception("Data dapur atau barang belum ada");
    }

    DB::table('stok_awal')->insert([
        [
            'barang_id' => $barang1->id,
            'dapur_id'  => $dapur1->id,
            'jumlah'    => 100,
            'created_at'=> now(),
            'updated_at'=> now(),
        ],
        [
            'barang_id' => $barang2?->id ?? $barang1->id,
            'dapur_id'  => $dapur2?->id ?? $dapur1->id,
            'jumlah'    => 50,
            'created_at'=> now(),
            'updated_at'=> now(),
        ],
    ]);

    DB::table('stok_barang')->insert([
        [
            'barang_id' => $barang1->id,
            'dapur_id'  => $dapur1->id,
            'stok'      => 100,
            'created_at'=> now(),
            'updated_at'=> now(),
        ],
        [
            'barang_id' => $barang2?->id ?? $barang1->id,
            'dapur_id'  => $dapur2?->id ?? $dapur1->id,
            'stok'      => 50,
            'created_at'=> now(),
            'updated_at'=> now(),
        ],
    ]);
}
}
