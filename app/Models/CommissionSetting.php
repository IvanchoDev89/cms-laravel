<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'rate',
        'type',
        'fixed_amount',
        'applies_to',
        'applicable_plans',
        'is_active',
        'description',
        'effective_from',
        'effective_until',
    ];

    protected $casts = [
        'rate' => 'decimal:2',
        'fixed_amount' => 'decimal:2',
        'applicable_plans' => 'array',
        'is_active' => 'boolean',
        'effective_from' => 'datetime',
        'effective_until' => 'datetime',
    ];

    public function calculateCommission(float $amount, ?SubscriptionPlan $plan = null): float
    {
        if (!$this->isActive()) {
            return 0;
        }

        // Check if commission applies to this plan
        if ($this->applies_to === 'specific_plans' && $plan) {
            if (!$this->applicable_plans || !in_array($plan->id, $this->applicable_plans)) {
                return 0;
            }
        }

        return match($this->type) {
            'percentage' => $amount * ($this->rate / 100),
            'fixed' => $this->fixed_amount,
            default => 0,
        };
    }

    public function isActive(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $now = now();

        if ($this->effective_from && $this->effective_from->isFuture()) {
            return false;
        }

        if ($this->effective_until && $this->effective_until->isPast()) {
            return false;
        }

        return true;
    }

    public function getFormattedRateAttribute(): string
    {
        return match($this->type) {
            'percentage' => $this->rate . '%',
            'fixed' => '$' . number_format($this->fixed_amount, 2),
            default => $this->rate,
        };
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where(function ($q) {
                        $q->whereNull('effective_from')
                          ->orWhere('effective_from', '<=', now());
                    })
                    ->where(function ($q) {
                        $q->whereNull('effective_until')
                          ->orWhere('effective_until', '>=', now());
                    });
    }

    public function scopeByName($query, string $name)
    {
        return $query->where('name', $name);
    }

    public function scopeAppliesTo($query, string $appliesTo)
    {
        return $query->where('applies_to', $appliesTo);
    }

    public static function getActiveByName(string $name): ?self
    {
        return static::active()->byName($name)->first();
    }
}
