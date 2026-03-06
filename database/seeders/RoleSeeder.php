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

        // Define permissions
        $permissions = [
            'view research',
            'create research',
            'edit research',
            'delete research',
            'view statistics',
            'manage users',
            'approve research',
        ];

        // Loop through and create permissions safely
        foreach ($permissions as $permission) {
            // Use firstOrCreate to prevent "Permission already exists" error
            Permission::firstOrCreate(['name' => $permission]);
        }

        // --- MIGRATION: Rename old roles if they exist ---
        // This ensures existing users keep their access level
        if (Role::where('name', 'head')->exists()) {
            Role::where('name', 'head')->update(['name' => 'Super Admin']);
        }
        if (Role::where('name', 'user')->exists()) {
            Role::where('name', 'user')->update(['name' => 'Research Staff']);
        }

        // --- ROLE CREATION ---

        // 1. Research Staff Role
        $staffRole = Role::firstOrCreate(['name' => 'Research Staff']);
        // Use syncPermissions to set permissions without duplicating
        $staffRole->syncPermissions([
            'view research',
            'create research',
            'edit research', 
        ]);

        // 2. Super Admin Role
        $adminRole = Role::firstOrCreate(['name' => 'Super Admin']);
        $adminRole->syncPermissions(Permission::all());
    }
}