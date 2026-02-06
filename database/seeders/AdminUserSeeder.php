<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('Secret123!'),
                'email_verified_at' => now(),
                'bio' => 'System administrator and content manager.',
                'title' => 'System Administrator',
                'show_profile_publicly' => true,
            ]
        );

        // Assign admin role
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $admin->assignRole($adminRole);
        }

        // Create some sample users for testing
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password'),
                'bio' => 'Full-stack developer and tech enthusiast.',
                'title' => 'Senior Developer',
                'location' => 'San Francisco, CA',
                'website' => 'https://johndoe.dev',
                'skills' => ['PHP', 'Laravel', 'JavaScript', 'Vue.js', 'Docker'],
                'show_profile_publicly' => true,
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => Hash::make('password'),
                'bio' => 'UX/UI designer passionate about creating beautiful user experiences.',
                'title' => 'Lead Designer',
                'location' => 'New York, NY',
                'website' => 'https://janesmith.design',
                'skills' => ['Figma', 'Adobe XD', 'Sketch', 'CSS', 'Prototyping'],
                'show_profile_publicly' => true,
            ],
        ];

        foreach ($users as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                $userData + ['email_verified_at' => now()]
            );

            // Assign author role to sample users
            $authorRole = Role::where('name', 'author')->first();
            if ($authorRole) {
                $user->assignRole($authorRole);
            }
        }
    }
}
