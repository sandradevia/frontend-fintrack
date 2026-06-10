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

        $adminYayasanRole = Role::firstOrCreate([
            'name' => 'admin_yayasan',
            'guard_name' => 'web'
        ]);

        $adminDapurRole = Role::firstOrCreate([
            'name' => 'admin_dapur',
            'guard_name' => 'web'
        ]);

        // SUPER ADMIN
        $superAdmin = User::updateOrCreate(
            ['username' => 'superadmin'],
            [
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'dapur_id' => null,
            ]
        );

        $superAdmin->syncRoles([$superRole]);

        // ADMIN YAYASAN
        $adminYayasan = User::updateOrCreate(
            ['username' => 'admin_yayasan'],
            [
                'password' => Hash::make('password'),
                'role' => 'admin_yayasan',
                'dapur_id' => null,
            ]
        );

        $adminYayasan->syncRoles([$adminYayasanRole]);

        // ADMIN DAPUR
        $adminDapur = User::updateOrCreate(
            ['username' => 'admin_dapur'],
            [
                'password' => Hash::make('password'),
                'role' => 'admin_dapur',
                'dapur_id' => Dapur::first()?->id,
            ]
        );

        $adminDapur->syncRoles([$adminDapurRole]);
    }
}