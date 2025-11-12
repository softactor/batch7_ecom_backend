<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Permissions
        Permission::create(['name' => 'view dashboard']);
        Permission::create(['name' => 'manage products']);
        Permission::create(['name' => 'manage categories']);
        Permission::create(['name' => 'manage orders']);
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'manage settings']);

        // Create Roles
        $adminRole = Role::create(['name' => 'admin']);
        $vendorRole = Role::create(['name' => 'vendor']);
        $customerRole = Role::create(['name' => 'customer']);

        // Assign Permissions to Roles
        $adminRole->givePermissionTo([
            'view dashboard',
            'manage products', 
            'manage categories',
            'manage orders',
            'manage users',
            'manage settings'
        ]);

        $vendorRole->givePermissionTo([
            'view dashboard',
            'manage products',
            'manage orders'
        ]);

        $customerRole->givePermissionTo([
            'view dashboard'
        ]);
    }
}
