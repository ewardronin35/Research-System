<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call the role seeder first
        $this->call(RoleSeeder::class);

        // Create a head user
        $head = User::create([
            'name' => 'Head of Research',
            'email' => 'head@example.com',
            'password' => Hash::make('password'),
        ]);
        $head->assignRole('head');

        // Create a regular user
        $user = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
        ]);
        $user->assignRole('user');

        // Create additional users if needed
        // User::factory(10)->create()->each(function ($user) {
        //     $user->assignRole('user');
        // });
    }
}