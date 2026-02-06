<?php

namespace App\Console\Commands;

use App\Models\Page;
use App\Models\Post;
use App\Models\Taxonomy;
use App\Models\User;
use Illuminate\Console\Command;

class SeedCmsData extends Command
{
    protected $signature = 'cms:seed';

    protected $description = 'Seed CMS data for testing';

    public function handle()
    {
        $this->info('Seeding CMS data...');

        // Create user if doesn't exist
        $user = User::first() ?: User::factory()->create(['email' => 'admin@cms.test']);

        // Create taxonomies
        $categories = [
            ['name' => 'Technology', 'slug' => 'technology', 'type' => 'category'],
            ['name' => 'Business', 'slug' => 'business', 'type' => 'category'],
            ['name' => 'Lifestyle', 'slug' => 'lifestyle', 'type' => 'category'],
        ];

        foreach ($categories as $cat) {
            Taxonomy::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        $this->info('✓ Taxonomies created');

        // Create sample posts
        $posts = [
            [
                'title' => 'Getting Started with Laravel',
                'slug' => 'getting-started-laravel',
                'excerpt' => 'Learn the basics of Laravel framework and build your first application.',
                'content' => 'Laravel is a powerful PHP framework that makes web development easy and enjoyable. In this guide, we\'ll explore the fundamentals and get you started building applications quickly.',
                'status' => 'published',
            ],
            [
                'title' => 'Best Practices for Web Development',
                'slug' => 'best-practices-web-dev',
                'excerpt' => 'Essential tips and tricks for writing clean, maintainable code.',
                'content' => 'Writing clean code is crucial for long-term project maintenance. Follow these best practices to improve your development workflow and create better applications.',
                'status' => 'published',
            ],
            [
                'title' => 'Understanding APIs',
                'slug' => 'understanding-apis',
                'excerpt' => 'A comprehensive guide to building and consuming REST APIs.',
                'content' => 'APIs are the backbone of modern web applications. Learn how to build robust APIs that scale and how to consume them effectively.',
                'status' => 'draft',
            ],
        ];

        foreach ($posts as $data) {
            $post = Post::updateOrCreate(
                ['slug' => $data['slug']],
                array_merge($data, [
                    'user_id' => $user->id,
                    'published_at' => now(),
                ])
            );

            $post->taxonomies()->sync([
                Taxonomy::where('type', 'category')->first()->id,
            ]);
        }

        $this->info('✓ Sample posts created');

        // Create sample pages
        $pages = [
            [
                'title' => 'About Us',
                'slug' => 'about',
                'excerpt' => 'Learn more about our mission and values.',
                'content' => 'We are a team dedicated to creating amazing web experiences and helping businesses succeed online.',
            ],
            [
                'title' => 'Contact Us',
                'slug' => 'contact',
                'excerpt' => 'Get in touch with our team.',
                'content' => 'Have questions? We\'d love to hear from you. Reach out to us and we\'ll get back to you as soon as possible.',
            ],
        ];

        foreach ($pages as $data) {
            Page::updateOrCreate(
                ['slug' => $data['slug']],
                array_merge($data, ['user_id' => $user->id])
            );
        }

        $this->info('✓ Sample pages created');
        $this->info('CMS data seeded successfully!');
    }
}
