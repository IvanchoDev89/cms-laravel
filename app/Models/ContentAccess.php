<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ContentAccess extends Model
{
    use HasFactory;

    protected $fillable = [
        'content_type',
        'content_id',
        'subscription_plan_id',
        'access_level',
        'required_features',
        'is_public',
        'requires_subscription',
        'individual_price',
        'currency',
        'available_from',
        'available_until',
    ];

    protected $casts = [
        'required_features' => 'array',
        'is_public' => 'boolean',
        'requires_subscription' => 'boolean',
        'individual_price' => 'decimal:2',
        'available_from' => 'datetime',
        'available_until' => 'datetime',
    ];

    public function content(): MorphTo
    {
        return $this->morphTo();
    }

    public function subscriptionPlan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    public function canBeAccessedBy(?User $user): bool
    {
        // If content is public, anyone can access
        if ($this->is_public) {
            return true;
        }

        // If no user provided, deny access
        if (!$user) {
            return false;
        }

        // Check if content is available
        if ($this->available_from && $this->available_from->isFuture()) {
            return false;
        }

        if ($this->available_until && $this->available_until->isPast()) {
            return false;
        }

        // If subscription is not required, allow access
        if (!$this->requires_subscription) {
            return true;
        }

        // Check user's subscription
        $subscription = $user->subscriptions()->active()->first();
        
        if (!$subscription) {
            return false;
        }

        // Check if user has the required subscription plan
        if ($this->subscription_plan_id && $subscription->plan_id !== $this->subscription_plan_id) {
            return false;
        }

        // Check if user has required features
        if ($this->required_features) {
            foreach ($this->required_features as $feature) {
                if (!$subscription->canAccessFeature($feature)) {
                    return false;
                }
            }
        }

        return true;
    }

    public function getAccessLevelTextAttribute(): string
    {
        return match($this->access_level) {
            'free' => 'Free',
            'premium' => 'Premium',
            'exclusive' => 'Exclusive',
            default => ucfirst($this->access_level),
        };
    }

    public function getFormattedPriceAttribute(): ?string
    {
        if ($this->individual_price) {
            return number_format($this->individual_price, 2) . ' ' . $this->currency;
        }
        return null;
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeRequiresSubscription($query)
    {
        return $query->where('requires_subscription', true);
    }

    public function scopeByAccessLevel($query, string $level)
    {
        return $query->where('access_level', $level);
    }

    public function scopeAvailable($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('available_from')
              ->orWhere('available_from', '<=', now());
        })->where(function ($q) {
            $q->whereNull('available_until')
              ->orWhere('available_until', '>=', now());
        });
    }
}
