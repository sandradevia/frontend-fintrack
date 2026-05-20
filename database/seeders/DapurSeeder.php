<?php

namespace Database\Seeders;

use App\Models\Dapur;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DapurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $admin1 = User::where('username', 'admin1')->first();
    $admin2 = User::where('username', 'admin2')->first();

    Dapur::create([
        'user_id' => $admin1->id,
        'nama_lembaga' => 'Dapur Utama',
        'alamat' => 'Jl. Contoh 1',
        'nama_kepala_sppg' => 'Budi',
        'nama_akuntan' => 'Siti',
        'nama_yayasan' => 'Yayasan A',
        'ketua_yayasan' => 'Andi',
        'nomor_rekening' => '123',
    ]);

    Dapur::create([
        'user_id' => $admin2->id,
        'nama_lembaga' => 'Dapur Cabang',
        'alamat' => 'Jl. Contoh 2',
        'nama_kepala_sppg' => 'Sari',
        'nama_akuntan' => 'Rina',
        'nama_yayasan' => 'Yayasan B',
        'ketua_yayasan' => 'Andi',
        'nomor_rekening' => '456',
    ]);
}
}
