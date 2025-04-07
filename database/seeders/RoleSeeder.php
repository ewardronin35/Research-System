<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'view research',
            'create research',
            'edit research',
            'delete research',
            'view statistics',
            'manage users',
            'approve research',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create User role and assign permissions
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo([
            'view research',
            'create research',
            'edit research', // User can only edit their own research
        ]);

        // Create Head role and assign permissions
        $headRole = Role::create(['name' => 'head']);
        $headRole->givePermissionTo(Permission::all()); // Head has all permissions
    }
}