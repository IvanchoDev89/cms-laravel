<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_id',
        'status',
        'amount_paid',
        'currency',
        'payment_method',
        'transaction_id',
        'starts_at',
        'ends_at',
        'cancelled_at',
        'trial_ends_at',
        'metadata',
    ];

    protected $casts = [
        'amount_paid' => 'decimal:2',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'trial_ends_at' => 'datetime',
        'metadata' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active' && 
               ($this->ends_at === null || $this->ends_at->isFuture());
    }

    public function isCancelled(): bool
    {
        return $this->cancelled_at !== null;
    }

    public function isOnTrial(): bool
    {
        return $this->trial_ends_at !== null && $this->trial_ends_at->isFuture();
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                    ->where(function ($q) {
                        $q->whereNull('ends_at')
                          ->orWhere('ends_at', '>', now());
                    });
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function canAccessFeature(string $feature): bool
    {
        if (!$this->isActive()) {
            return false;
        }

        return match($feature) {
            'premium_content' => $this->plan->can_access_premium_content,
            'private_content' => $this->plan->can_create_private_content,
            'comment_moderation' => $this->plan->can_moderate_comments,
            'advanced_analytics' => $this->plan->can_use_advanced_analytics,
            'no_branding' => $this->plan->can_remove_branding,
            default => false,
        };
    }
}
