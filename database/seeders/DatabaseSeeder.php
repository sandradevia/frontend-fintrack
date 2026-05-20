<?php

namespace Database\Seeders;

use App\Models\Pekerjaan;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            UserSeeder::class,
            DapurSeeder::class,
            pekerjaanSeeder::class,
            AnggotaSeeder::class,
            BarangSeeder::class,
            StokSeeder::class,
            AkunSeeder::class,
            TransaksiSeeder::class,
            JurnalSeeder::class,
            BkuSeeder::class,
            AnggaranSeeder::class,
            NominatifSeeder::class,
        ]);
    }
}
