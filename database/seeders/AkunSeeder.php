<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AkunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('akuns')->insert([
            ['id'=>1,'kode'=>'1000','nama_akun'=>'BUKU KAS UMUM'],
            ['id'=>2,'kode'=>'1100','nama_akun'=>'BUKU PEMBANTU KAS'],
        ]);
    }
}
