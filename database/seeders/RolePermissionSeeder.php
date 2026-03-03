<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $super = Role::firstOrCreate(['name' => 'super_admin']);
        $admin = Role::firstOrCreate(['name' => 'admin']);

        $perms = [
            'users.manage',
            'roles.manage',
            'reports.view',
            'stock.manage',
            'budget.manage',
        ];

        foreach ($perms as $p) {
            Permission::firstOrCreate(['name' => $p]);
        }

        // super admin bisa semua
        $super->syncPermissions(Permission::all());

        // admin default minimal (nanti super admin bisa tambah)
        $admin->syncPermissions(['reports.view']);
    }
}