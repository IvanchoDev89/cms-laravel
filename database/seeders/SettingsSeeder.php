<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            ['key' => 'site_name', 'value' => 'My CMS', 'type' => 'string', 'group' => 'general', 'label' => 'Site Name', 'is_public' => true],
            ['key' => 'site_tagline', 'value' => 'A modern content management system', 'type' => 'string', 'group' => 'general', 'label' => 'Site Tagline', 'is_public' => true],
            ['key' => 'site_description', 'value' => 'Welcome to our content management platform', 'type' => 'text', 'group' => 'general', 'label' => 'Site Description', 'is_public' => true],
            ['key' => 'site_logo', 'value' => '/images/logo.png', 'type' => 'string', 'group' => 'general', 'label' => 'Site Logo URL'],
            ['key' => 'favicon', 'value' => '/favicon.ico', 'type' => 'string', 'group' => 'general', 'label' => 'Favicon URL'],

            // SEO
            ['key' => 'meta_title_suffix', 'value' => ' | My CMS', 'type' => 'string', 'group' => 'seo', 'label' => 'Meta Title Suffix', 'is_public' => true],
            ['key' => 'meta_description_default', 'value' => 'Discover amazing content on our platform', 'type' => 'text', 'group' => 'seo', 'label' => 'Default Meta Description', 'is_public' => true],
            ['key' => 'og_image_default', 'value' => '/images/og-default.png', 'type' => 'string', 'group' => 'seo', 'label' => 'Default OG Image'],
            ['key' => 'google_analytics_id', 'value' => '', 'type' => 'string', 'group' => 'seo', 'label' => 'Google Analytics ID'],
            ['key' => 'enable_sitemap', 'value' => 'true', 'type' => 'boolean', 'group' => 'seo', 'label' => 'Enable XML Sitemap', 'is_public' => true],

            // Content
            ['key' => 'posts_per_page', 'value' => '12', 'type' => 'integer', 'group' => 'content', 'label' => 'Posts Per Page', 'is_public' => true],
            ['key' => 'enable_comments', 'value' => 'true', 'type' => 'boolean', 'group' => 'content', 'label' => 'Enable Comments', 'is_public' => true],
            ['key' => 'comments_need_approval', 'value' => 'true', 'type' => 'boolean', 'group' => 'content', 'label' => 'Comments Need Approval'],
            ['key' => 'allow_guest_comments', 'value' => 'false', 'type' => 'boolean', 'group' => 'content', 'label' => 'Allow Guest Comments'],

            // Social
            ['key' => 'facebook_url', 'value' => '', 'type' => 'string', 'group' => 'social', 'label' => 'Facebook URL', 'is_public' => true],
            ['key' => 'twitter_url', 'value' => '', 'type' => 'string', 'group' => 'social', 'label' => 'Twitter URL', 'is_public' => true],
            ['key' => 'instagram_url', 'value' => '', 'type' => 'string', 'group' => 'social', 'label' => 'Instagram URL', 'is_public' => true],
            ['key' => 'linkedin_url', 'value' => '', 'type' => 'string', 'group' => 'social', 'label' => 'LinkedIn URL', 'is_public' => true],

            // Advanced
            ['key' => 'maintenance_mode', 'value' => 'false', 'type' => 'boolean', 'group' => 'advanced', 'label' => 'Maintenance Mode'],
            ['key' => 'maintenance_message', 'value' => 'We are currently performing maintenance. Please check back soon.', 'type' => 'text', 'group' => 'advanced', 'label' => 'Maintenance Message'],
            ['key' => 'enable_registration', 'value' => 'true', 'type' => 'boolean', 'group' => 'advanced', 'label' => 'Enable User Registration'],
            ['key' => 'default_user_role', 'value' => 'user', 'type' => 'string', 'group' => 'advanced', 'label' => 'Default User Role'],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
