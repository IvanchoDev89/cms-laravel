<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_type',
        'owner_id',
        'balance',
        'total_earned',
        'total_withdrawn',
        'currency',
        'is_active',
        'last_transaction_at',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'total_earned' => 'decimal:2',
        'total_withdrawn' => 'decimal:2',
        'is_active' => 'boolean',
        'last_transaction_at' => 'datetime',
    ];

    public function owner(): MorphTo
    {
        return $this->morphTo();
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function credit(float $amount, string $description, array $metadata = []): Transaction
    {
        $this->balance += $amount;
        $this->total_earned += $amount;
        $this->last_transaction_at = now();
        $this->save();

        return $this->transactions()->create([
            'type' => 'credit',
            'amount' => $amount,
            'description' => $description,
            'metadata' => $metadata,
            'processed_at' => now(),
        ]);
    }

    public function debit(float $amount, string $description, array $metadata = []): Transaction
    {
        if ($this->balance < $amount) {
            throw new \Exception('Insufficient balance');
        }

        $this->balance -= $amount;
        $this->total_withdrawn += $amount;
        $this->last_transaction_at = now();
        $this->save();

        return $this->transactions()->create([
            'type' => 'debit',
            'amount' => $amount,
            'description' => $description,
            'metadata' => $metadata,
            'processed_at' => now(),
        ]);
    }

    public function getFormattedBalanceAttribute(): string
    {
        return number_format($this->balance, 2).' '.$this->currency;
    }

    public function getFormattedTotalEarnedAttribute(): string
    {
        return number_format($this->total_earned, 2).' '.$this->currency;
    }

    public function getFormattedTotalWithdrawnAttribute(): string
    {
        return number_format($this->total_withdrawn, 2).' '.$this->currency;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForOwner($query, $owner)
    {
        return $query->where('owner_type', get_class($owner))
            ->where('owner_id', $owner->id);
    }

    public static function getOrCreateForOwner($owner): self
    {
        $wallet = static::forOwner($owner)->first();

        if (! $wallet) {
            $wallet = static::create([
                'owner_type' => get_class($owner),
                'owner_id' => $owner->id,
                'currency' => 'USD',
            ]);
        }

        return $wallet;
    }
}
