<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Free',
                'slug' => 'free',
                'description' => 'Perfect for getting started with basic features',
                'price' => 0.00,
                'currency' => 'USD',
                'billing_cycle' => 'monthly',
                'features' => [
                    'Basic content creation',
                    'Public content access',
                    'Community support',
                    'Basic analytics',
                ],
                'max_articles' => 10,
                'max_media_storage' => 100, // 100MB
                'can_access_premium_content' => false,
                'can_create_private_content' => false,
                'can_moderate_comments' => false,
                'can_use_advanced_analytics' => false,
                'can_remove_branding' => false,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Creator',
                'slug' => 'creator',
                'description' => 'For content creators who need more features and storage',
                'price' => 19.99,
                'currency' => 'USD',
                'billing_cycle' => 'monthly',
                'features' => [
                    'Unlimited content creation',
                    'Premium content access',
                    'Private content creation',
                    'Advanced analytics',
                    'Priority support',
                    'Custom branding',
                ],
                'max_articles' => null, // unlimited
                'max_media_storage' => 5000, // 5GB
                'can_access_premium_content' => true,
                'can_create_private_content' => true,
                'can_moderate_comments' => false,
                'can_use_advanced_analytics' => true,
                'can_remove_branding' => false,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Professional',
                'slug' => 'professional',
                'description' => 'For professionals and businesses with advanced needs',
                'price' => 49.99,
                'currency' => 'USD',
                'billing_cycle' => 'monthly',
                'features' => [
                    'Everything in Creator',
                    'Comment moderation',
                    'Team collaboration',
                    'API access',
                    'Advanced SEO tools',
                    'No branding',
                    'Dedicated support',
                ],
                'max_articles' => null, // unlimited
                'max_media_storage' => 20000, // 20GB
                'can_access_premium_content' => true,
                'can_create_private_content' => true,
                'can_moderate_comments' => true,
                'can_use_advanced_analytics' => true,
                'can_remove_branding' => true,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Enterprise',
                'slug' => 'enterprise',
                'description' => 'Custom solutions for large organizations',
                'price' => 199.99,
                'currency' => 'USD',
                'billing_cycle' => 'monthly',
                'features' => [
                    'Everything in Professional',
                    'Unlimited storage',
                    'White-label solution',
                    'Custom integrations',
                    'SLA guarantee',
                    'Account manager',
                    'Custom training',
                ],
                'max_articles' => null, // unlimited
                'max_media_storage' => null, // unlimited
                'can_access_premium_content' => true,
                'can_create_private_content' => true,
                'can_moderate_comments' => true,
                'can_use_advanced_analytics' => true,
                'can_remove_branding' => true,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Lifetime',
                'slug' => 'lifetime',
                'description' => 'One-time payment for lifetime access to all features',
                'price' => 999.99,
                'currency' => 'USD',
                'billing_cycle' => 'lifetime',
                'features' => [
                    'All Professional features',
                    'Lifetime updates',
                    'No recurring fees',
                    'Priority feature requests',
                    'VIP support',
                ],
                'max_articles' => null, // unlimited
                'max_media_storage' => null, // unlimited
                'can_access_premium_content' => true,
                'can_create_private_content' => true,
                'can_moderate_comments' => true,
                'can_use_advanced_analytics' => true,
                'can_remove_branding' => true,
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::create($plan);
        }
    }
}
