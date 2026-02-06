<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\Post;
use App\Models\Taxonomy;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SampleContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users for content creation
        $admin = User::where('email', 'admin@example.com')->first();
        $john = User::where('email', 'john@example.com')->first();
        $jane = User::where('email', 'jane@example.com')->first();

        // Create categories
        $categories = [
            ['name' => 'Technology', 'type' => 'category'],
            ['name' => 'Design', 'type' => 'category'],
            ['name' => 'Business', 'type' => 'category'],
            ['name' => 'Development', 'type' => 'category'],
        ];

        foreach ($categories as $category) {
            Taxonomy::firstOrCreate(
                ['slug' => Str::slug($category['name'])],
                $category + ['slug' => Str::slug($category['name'])]
            );
        }

        // Create tags
        $tags = [
            ['name' => 'Laravel', 'type' => 'tag'],
            ['name' => 'PHP', 'type' => 'tag'],
            ['name' => 'JavaScript', 'type' => 'tag'],
            ['name' => 'Vue.js', 'type' => 'tag'],
            ['name' => 'UI/UX', 'type' => 'tag'],
            ['name' => 'Web Development', 'type' => 'tag'],
            ['name' => 'Tutorial', 'type' => 'tag'],
            ['name' => 'Best Practices', 'type' => 'tag'],
        ];

        foreach ($tags as $tag) {
            Taxonomy::firstOrCreate(
                ['slug' => Str::slug($tag['name'])],
                $tag + ['slug' => Str::slug($tag['name'])]
            );
        }

        // Create sample posts
        $posts = [
            [
                'title' => 'Getting Started with Laravel 12',
                'slug' => 'getting-started-laravel-12',
                'excerpt' => 'Learn the basics of Laravel 12 and how to set up your first application.',
                'content' => 'Laravel 12 brings exciting new features and improvements. In this comprehensive guide, we\'ll explore the fundamentals of modern Laravel development, from installation to deployment.',
                'status' => 'published',
                'published_at' => now()->subDays(5),
                'meta_title' => 'Getting Started with Laravel 12 - Complete Guide',
                'meta_description' => 'Learn Laravel 12 from scratch with this comprehensive tutorial covering installation, setup, and best practices.',
                'meta_keywords' => 'Laravel, PHP, Web Development, Tutorial',
                'user_id' => $john->id,
            ],
            [
                'title' => 'Modern UI/UX Design Principles',
                'slug' => 'modern-ui-ux-design-principles',
                'excerpt' => 'Explore the latest trends and principles in modern user interface and experience design.',
                'content' => 'Design is not just about making things look pretty. It\'s about creating intuitive, accessible, and delightful experiences for users. Let\'s dive into the core principles that define modern UI/UX.',
                'status' => 'published',
                'published_at' => now()->subDays(3),
                'meta_title' => 'Modern UI/UX Design Principles - 2024 Guide',
                'meta_description' => 'Discover essential UI/UX design principles and best practices for creating user-centered digital products.',
                'meta_keywords' => 'UI Design, UX Design, User Experience, Design Principles',
                'user_id' => $jane->id,
            ],
            [
                'title' => 'Building Scalable Web Applications',
                'slug' => 'building-scalable-web-applications',
                'excerpt' => 'Best practices for building web applications that can grow with your business.',
                'content' => 'Scalability is crucial for modern web applications. Learn about architectural patterns, database optimization, caching strategies, and deployment techniques that ensure your application can handle growth.',
                'status' => 'published',
                'published_at' => now()->subDays(1),
                'meta_title' => 'Building Scalable Web Applications - Architecture Guide',
                'meta_description' => 'Learn how to build web applications that scale efficiently with proven architectural patterns and best practices.',
                'meta_keywords' => 'Scalability, Web Development, Architecture, Performance',
                'user_id' => $admin->id,
            ],
            [
                'title' => 'The Future of Web Development',
                'slug' => 'future-of-web-development',
                'excerpt' => 'Exploring emerging technologies and trends shaping the future of web development.',
                'content' => 'From WebAssembly to AI-powered development tools, the landscape of web development is constantly evolving. Let\'s explore what the future holds for developers and businesses.',
                'status' => 'draft',
                'published_at' => null,
                'meta_title' => 'The Future of Web Development - Trends and Predictions',
                'meta_description' => 'Discover emerging technologies and trends that will shape the future of web development in the coming years.',
                'meta_keywords' => 'Future Tech, Web Development, Trends, Innovation',
                'user_id' => $john->id,
            ],
        ];

        foreach ($posts as $postData) {
            $post = Post::firstOrCreate(
                ['slug' => $postData['slug']],
                $postData
            );

            // Attach categories and tags
            $techCategory = Taxonomy::where('slug', 'technology')->first();
            $devCategory = Taxonomy::where('slug', 'development')->first();
            $designCategory = Taxonomy::where('slug', 'design')->first();

            $laravelTag = Taxonomy::where('slug', 'laravel')->first();
            $phpTag = Taxonomy::where('slug', 'php')->first();
            $uxTag = Taxonomy::where('slug', 'ui-ux')->first();
            $tutorialTag = Taxonomy::where('slug', 'tutorial')->first();

            if ($post->slug === 'getting-started-laravel-12') {
                $attachments = array_filter([$techCategory?->id, $devCategory?->id, $laravelTag?->id, $phpTag?->id, $tutorialTag?->id]);
                if (! empty($attachments)) {
                    $post->taxonomies()->syncWithoutDetaching($attachments);
                }
            } elseif ($post->slug === 'modern-ui-ux-design-principles') {
                $attachments = array_filter([$designCategory?->id, $uxTag?->id, $tutorialTag?->id]);
                if (! empty($attachments)) {
                    $post->taxonomies()->syncWithoutDetaching($attachments);
                }
            } elseif ($post->slug === 'building-scalable-web-applications') {
                $attachments = array_filter([$techCategory?->id, $devCategory?->id]);
                if (! empty($attachments)) {
                    $post->taxonomies()->syncWithoutDetaching($attachments);
                }
            }
        }

        // Create sample pages
        $pages = [
            [
                'title' => 'About Us',
                'slug' => 'about-us',
                'excerpt' => 'Learn more about our company and mission.',
                'content' => 'We are a team of passionate developers and designers dedicated to creating exceptional digital experiences. Our mission is to help businesses leverage technology to achieve their goals.',
                'meta_title' => 'About Us - Our Story and Mission',
                'meta_description' => 'Learn about our team, values, and commitment to delivering exceptional digital solutions.',
                'meta_keywords' => 'About, Company, Team, Mission',
                'user_id' => $admin->id,
            ],
            [
                'title' => 'Contact',
                'slug' => 'contact',
                'excerpt' => 'Get in touch with our team.',
                'content' => 'We\'d love to hear from you! Whether you have a project in mind, need technical assistance, or just want to chat about technology, our team is here to help.',
                'meta_title' => 'Contact Us - Get in Touch',
                'meta_description' => 'Contact our team for inquiries, projects, or support. We\'re here to help you succeed.',
                'meta_keywords' => 'Contact, Support, Inquiry, Help',
                'user_id' => $admin->id,
            ],
            [
                'title' => 'Services',
                'slug' => 'services',
                'excerpt' => 'Explore our range of professional services.',
                'content' => 'We offer comprehensive services including web development, mobile app development, UI/UX design, and consulting. Let us help you bring your ideas to life.',
                'meta_title' => 'Our Services - Web Development & Design',
                'meta_description' => 'Discover our professional services including web development, mobile apps, UI/UX design, and technical consulting.',
                'meta_keywords' => 'Services, Development, Design, Consulting',
                'user_id' => $admin->id,
            ],
        ];

        foreach ($pages as $pageData) {
            Page::firstOrCreate(
                ['slug' => $pageData['slug']],
                $pageData
            );
        }
    }
}
