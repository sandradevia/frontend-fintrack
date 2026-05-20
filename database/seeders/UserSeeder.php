<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ROLE
        $superRole = Role::firstOrCreate([
            'name' => 'super_admin',
            'guard_name' => 'web'
        ]);

        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web'
        ]);

        // SUPER ADMIN
        $super = User::updateOrCreate(
            ['username' => 'superadmin'],
            [
                'password' => Hash::make('password'),
                'role' => 'super_admin',
            ]
        );

        $super->syncRoles([$superRole]);

        // ADMIN 1
        $admin1 = User::updateOrCreate(
            ['username' => 'admin1'],
            [
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        $admin1->syncRoles([$adminRole]);

        // ADMIN 2
        $admin2 = User::updateOrCreate(
            ['username' => 'admin2'],
            [
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        $admin2->syncRoles([$adminRole]);
    }
}