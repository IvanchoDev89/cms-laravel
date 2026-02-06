<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id',
        'type',
        'amount',
        'currency',
        'description',
        'reference_type',
        'reference_id',
        'commission_rate',
        'commission_amount',
        'status',
        'metadata',
        'processed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'commission_rate' => 'decimal:2',
        'commission_amount' => 'decimal:2',
        'metadata' => 'array',
        'processed_at' => 'datetime',
    ];

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    public function reference()
    {
        if ($this->reference_type && $this->reference_id) {
            return $this->belongsTo($this->reference_type, 'reference_id');
        }

        return null;
    }

    public function isCredit(): bool
    {
        return $this->type === 'credit';
    }

    public function isDebit(): bool
    {
        return $this->type === 'debit';
    }

    public function isCommission(): bool
    {
        return $this->type === 'commission';
    }

    public function isWithdrawal(): bool
    {
        return $this->type === 'withdrawal';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function getFormattedAmountAttribute(): string
    {
        $prefix = $this->isDebit() ? '-' : '+';

        return $prefix.number_format($this->amount, 2).' '.$this->currency;
    }

    public function getFormattedCommissionAmountAttribute(): ?string
    {
        if ($this->commission_amount) {
            return number_format($this->commission_amount, 2).' '.$this->currency;
        }

        return null;
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCredits($query)
    {
        return $query->where('type', 'credit');
    }

    public function scopeDebits($query)
    {
        return $query->where('type', 'debit');
    }

    public function scopeCommissions($query)
    {
        return $query->where('type', 'commission');
    }

    public function scopeForWallet($query, $walletId)
    {
        return $query->where('wallet_id', $walletId);
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeWithReference($query, string $referenceType, $referenceId)
    {
        return $query->where('reference_type', $referenceType)
            ->where('reference_id', $referenceId);
    }
}
