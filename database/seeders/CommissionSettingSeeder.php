<?php

namespace Database\Seeders;

use App\Models\CommissionSetting;
use Illuminate\Database\Seeder;

class CommissionSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            [
                'name' => 'subscription_commission',
                'rate' => 10.00, // 10%
                'type' => 'percentage',
                'applies_to' => 'all_users',
                'description' => 'Commission on all subscription payments',
                'is_active' => true,
            ],
            [
                'name' => 'content_purchase_commission',
                'rate' => 15.00, // 15%
                'type' => 'percentage',
                'applies_to' => 'content_creators',
                'description' => 'Higher commission for content creators',
                'is_active' => true,
            ],
            [
                'name' => 'premium_plan_commission',
                'rate' => 5.00, // 5%
                'type' => 'percentage',
                'applies_to' => 'specific_plans',
                'applicable_plans' => [3, 4], // Professional and Enterprise plans
                'description' => 'Lower commission for premium plans',
                'is_active' => true,
            ],
            [
                'name' => 'lifetime_plan_commission',
                'rate' => 7.50, // 7.5%
                'type' => 'percentage',
                'applies_to' => 'specific_plans',
                'applicable_plans' => [5], // Lifetime plan
                'description' => 'Special commission rate for lifetime plans',
                'is_active' => true,
            ],
        ];

        foreach ($settings as $setting) {
            CommissionSetting::create($setting);
        }
    }
}
