<?php

namespace Database\Seeders;

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
        // Seed roles & permissions
        $this->call(RolePermissionSeeder::class);

        // Create a default test user
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        // Create an admin user for development if not present
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'password' => bcrypt('Secret123!'),
                'email_verified_at' => now(),
            ]
        );

        // Assign admin role
        try {
            $admin->assignRole('admin');
        } catch (\Throwable $e) {
            // ignore if role assignment fails (e.g., during tests)
        }
    }
}
