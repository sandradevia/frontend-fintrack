<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PekerjaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pekerjaans')->insert([
            ['id'=>1,'nama_pekerjaan'=>'Koki'],
            ['id'=>2,'nama_pekerjaan'=>'Admin'],
        ]);
    }
}
