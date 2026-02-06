<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'content',
        'type',
        'attachments',
        'is_read',
        'read_at',
        'status',
        'edited_at',
        'deleted_at',
    ];

    protected $casts = [
        'attachments' => 'array',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'edited_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function markAsRead(): bool
    {
        if (! $this->is_read) {
            $this->is_read = true;
            $this->read_at = now();
            $this->status = 'read';

            return $this->save();
        }

        return false;
    }

    public function isDelivered(): bool
    {
        return in_array($this->status, ['sent', 'delivered', 'read']);
    }

    public function isSystemMessage(): bool
    {
        return $this->type === 'system';
    }

    public function hasAttachments(): bool
    {
        return ! empty($this->attachments);
    }

    public function getAttachmentCountAttribute(): int
    {
        return $this->hasAttachments() ? count($this->attachments) : 0;
    }

    public function scopeBetween($query, $userId1, $userId2)
    {
        return $query->where(function ($q) use ($userId1, $userId2) {
            $q->where('sender_id', $userId1)->where('receiver_id', $userId2);
        })->orWhere(function ($q) use ($userId1, $userId2) {
            $q->where('sender_id', $userId2)->where('receiver_id', $userId1);
        });
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('receiver_id', $userId);
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeNotDeleted($query)
    {
        return $query->whereNull('deleted_at');
    }
}
