<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            // Posts
            ['name' => 'posts.view', 'display_name' => 'View Posts', 'description' => 'View all posts'],
            ['name' => 'posts.create', 'display_name' => 'Create Posts', 'description' => 'Create new posts'],
            ['name' => 'posts.edit', 'display_name' => 'Edit Posts', 'description' => 'Edit own and other posts'],
            ['name' => 'posts.delete', 'display_name' => 'Delete Posts', 'description' => 'Delete posts'],
            ['name' => 'posts.publish', 'display_name' => 'Publish Posts', 'description' => 'Publish/unpublish posts'],

            // Pages
            ['name' => 'pages.view', 'display_name' => 'View Pages', 'description' => 'View all pages'],
            ['name' => 'pages.create', 'display_name' => 'Create Pages', 'description' => 'Create new pages'],
            ['name' => 'pages.edit', 'display_name' => 'Edit Pages', 'description' => 'Edit pages'],
            ['name' => 'pages.delete', 'display_name' => 'Delete Pages', 'description' => 'Delete pages'],

            // Media
            ['name' => 'media.view', 'display_name' => 'View Media', 'description' => 'View all media'],
            ['name' => 'media.upload', 'display_name' => 'Upload Media', 'description' => 'Upload new media'],
            ['name' => 'media.delete', 'display_name' => 'Delete Media', 'description' => 'Delete media'],

            // Categories & Tags
            ['name' => 'taxonomies.manage', 'display_name' => 'Manage Taxonomies', 'description' => 'Create and edit categories/tags'],

            // Users & Roles
            ['name' => 'users.view', 'display_name' => 'View Users', 'description' => 'View all users'],
            ['name' => 'users.manage', 'display_name' => 'Manage Users', 'description' => 'Create, edit, delete users'],
            ['name' => 'roles.manage', 'display_name' => 'Manage Roles', 'description' => 'Create and edit roles/permissions'],

            // Settings
            ['name' => 'settings.view', 'display_name' => 'View Settings', 'description' => 'View site settings'],
            ['name' => 'settings.manage', 'display_name' => 'Manage Settings', 'description' => 'Edit site settings'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission['name']], $permission);
        }

        // Create roles
        $admin = Role::firstOrCreate(
            ['name' => 'admin'],
            ['display_name' => 'Administrator', 'description' => 'Full access to all features']
        );

        $editor = Role::firstOrCreate(
            ['name' => 'editor'],
            ['display_name' => 'Editor', 'description' => 'Can manage content and media']
        );

        $author = Role::firstOrCreate(
            ['name' => 'author'],
            ['display_name' => 'Author', 'description' => 'Can create and edit own posts']
        );

        $subscriber = Role::firstOrCreate(
            ['name' => 'subscriber'],
            ['display_name' => 'Subscriber', 'description' => 'Can view published content']
        );

        // Grant permissions to admin (all)
        foreach ($permissions as $permission) {
            $admin->grantPermission($permission['name']);
        }

        // Grant permissions to editor
        $editorPermissions = [
            'posts.view', 'posts.create', 'posts.edit', 'posts.delete', 'posts.publish',
            'pages.view', 'pages.create', 'pages.edit', 'pages.delete',
            'media.view', 'media.upload', 'media.delete',
            'taxonomies.manage',
        ];
        foreach ($editorPermissions as $permission) {
            $editor->grantPermission($permission);
        }

        // Grant permissions to author
        $authorPermissions = ['posts.view', 'posts.create', 'posts.edit', 'media.view', 'media.upload'];
        foreach ($authorPermissions as $permission) {
            $author->grantPermission($permission);
        }

        // Grant permissions to subscriber
        $subscriber->grantPermission('posts.view');
    }
}
