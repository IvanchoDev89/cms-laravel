<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // Main Navigation Menu
        $mainMenu = Menu::create([
            'name' => 'Main Navigation',
            'slug' => 'main-navigation',
            'location' => 'header',
            'description' => 'Primary site navigation menu',
            'is_active' => true,
        ]);

        MenuItem::create([
            'menu_id' => $mainMenu->id,
            'title' => 'Home',
            'route_name' => 'home',
            'order' => 1,
            'type' => 'route',
            'is_active' => true,
        ]);

        MenuItem::create([
            'menu_id' => $mainMenu->id,
            'title' => 'Blog',
            'route_name' => 'posts.index',
            'order' => 2,
            'type' => 'route',
            'is_active' => true,
        ]);

        MenuItem::create([
            'menu_id' => $mainMenu->id,
            'title' => 'Dashboard',
            'route_name' => 'dashboard',
            'order' => 3,
            'type' => 'route',
            'is_active' => true,
        ]);

        // Footer Menu
        $footerMenu = Menu::create([
            'name' => 'Footer Menu',
            'slug' => 'footer-menu',
            'location' => 'footer',
            'description' => 'Footer navigation links',
            'is_active' => true,
        ]);

        MenuItem::create([
            'menu_id' => $footerMenu->id,
            'title' => 'About Us',
            'url' => '/about',
            'order' => 1,
            'type' => 'custom',
            'is_active' => true,
        ]);

        MenuItem::create([
            'menu_id' => $footerMenu->id,
            'title' => 'Contact',
            'url' => '/contact',
            'order' => 2,
            'type' => 'custom',
            'is_active' => true,
        ]);

        MenuItem::create([
            'menu_id' => $footerMenu->id,
            'title' => 'Privacy Policy',
            'url' => '/privacy',
            'order' => 3,
            'type' => 'custom',
            'is_active' => true,
        ]);
    }
}
