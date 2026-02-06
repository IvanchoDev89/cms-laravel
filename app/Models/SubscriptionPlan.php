<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'currency',
        'billing_cycle',
        'features',
        'max_articles',
        'max_media_storage',
        'can_access_premium_content',
        'can_create_private_content',
        'can_moderate_comments',
        'can_use_advanced_analytics',
        'can_remove_branding',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'features' => 'array',
        'is_active' => 'boolean',
        'can_access_premium_content' => 'boolean',
        'can_create_private_content' => 'boolean',
        'can_moderate_comments' => 'boolean',
        'can_use_advanced_analytics' => 'boolean',
        'can_remove_branding' => 'boolean',
    ];

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 2) . ' ' . $this->currency;
    }

    public function getBillingCycleTextAttribute(): string
    {
        return match($this->billing_cycle) {
            'monthly' => 'per month',
            'yearly' => 'per year',
            'lifetime' => 'one-time',
            default => $this->billing_cycle,
        };
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('price');
    }
}
