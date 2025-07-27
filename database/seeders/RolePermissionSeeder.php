<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'manage users',
            'view users',
            'manage master data kategori',
            'manage master data sub kategori',

            'manage items',
            'view items'
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $operator = Role::firstOrCreate(['name' => 'operator']);

        // Admin: all permissions
        $admin->syncPermissions(Permission::all());

        // Operator: everything except users
        $operator->syncPermissions([
            'manage items',
            'view items',
        ]);
    }
}
