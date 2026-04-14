<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnggotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('anggota')->insert([
            ['id'=>1,'nama'=>'Joko','pekerjaan_id'=>1,'dapur_id'=>1],
            ['id'=>2,'nama'=>'Ani','pekerjaan_id'=>2,'dapur_id'=>2],
        ]);
    }
}
