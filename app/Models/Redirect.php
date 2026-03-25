<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Redirect extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_url',
        'to_url',
        'status_code',
        'type',
        'hits_count',
        'last_used_at',
        'created_by',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'hits_count' => 'integer',
        'last_used_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePermanent($query)
    {
        return $query->where('status_code', 301);
    }

    public function scopeTemporary($query)
    {
        return $query->whereIn('status_code', [302, 307]);
    }

    public function incrementHits()
    {
        $this->increment('hits_count');
        $this->update(['last_used_at' => now()]);
    }
}
