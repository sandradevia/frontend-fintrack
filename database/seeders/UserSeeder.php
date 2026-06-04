<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Dapur;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $superRole = Role::firstOrCreate([
            'name' => 'super_admin',
            'guard_name' => 'web'
        ]);

        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web'
        ]);

        $dapurUtama = Dapur::where('nama_lembaga', 'Dapur Utama')->first();
        $dapurCabang = Dapur::where('nama_lembaga', 'Dapur Cabang')->first();

        // SUPER ADMIN
        $super = User::updateOrCreate(
            ['username' => 'superadmin'],
            [
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'dapur_id' => $dapurUtama?->id,
            ]
        );

        $super->syncRoles([$superRole]);

        // ADMIN 1
        $admin1 = User::updateOrCreate(
            ['username' => 'admin1'],
            [
                'password' => Hash::make('password'),
                'role' => 'admin',
                'dapur_id' => $dapurUtama?->id,
            ]
        );

        $admin1->syncRoles([$adminRole]);

        // ADMIN 2
        $admin2 = User::updateOrCreate(
            ['username' => 'admin2'],
            [
                'password' => Hash::make('password'),
                'role' => 'admin',
                'dapur_id' => $dapurCabang?->id,
            ]
        );

        $admin2->syncRoles([$adminRole]);
    }
}