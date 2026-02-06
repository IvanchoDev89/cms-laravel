<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'bio',
        'title',
        'location',
        'website',
        'phone',
        'skills',
        'experience',
        'education',
        'social_links',
        'profile_image_path',
        'show_profile_publicly',
        'show_email_publicly',
        'show_phone_publicly',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'skills' => 'array',
        'experience' => 'array',
        'education' => 'array',
        'social_links' => 'array',
        'show_profile_publicly' => 'boolean',
        'show_email_publicly' => 'boolean',
        'show_phone_publicly' => 'boolean',
    ];

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    /**
     * Get the roles for this user.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_role')
            ->withTimestamps();
    }

    /**
     * Get the posts authored by the user.
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    /**
     * Check if user has a specific role.
     */
    public function hasRole(string|array $roles): bool
    {
        if (is_string($roles)) {
            return $this->roles()->where('name', $roles)->exists();
        }
        return $this->roles()->whereIn('name', $roles)->exists();
    }

    /**
     * Check if user has a specific permission (through their roles).
     */
    public function hasPermission(string $permissionName): bool
    {
        return $this->roles()
            ->whereHas('permissions', fn ($q) => $q->where('name', $permissionName))
            ->exists();
    }

    /**
     * Check if user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * Assign a role to this user.
     */
    public function assignRole(Role|string $role): void
    {
        if (is_string($role)) {
            $role = Role::where('name', $role)->firstOrFail();
        }
        if (!$this->roles()->where('role_id', $role->id)->exists()) {
            $this->roles()->attach($role);
        }
    }

    /**
     * Remove a role from this user.
     */
    public function removeRole(Role|string $role): void
    {
        if (is_string($role)) {
            $role = Role::where('name', $role)->firstOrFail();
        }
        $this->roles()->detach($role);
    }

    /**
     * Get the user's public profile data.
     */
    public function getPublicProfile(): array
    {
        if (!$this->show_profile_publicly) {
            return [];
        }

        $data = [
            'name' => $this->name,
            'title' => $this->title,
            'location' => $this->location,
            'website' => $this->website,
            'bio' => $this->bio,
            'skills' => $this->skills,
            'experience' => $this->experience,
            'education' => $this->education,
            'social_links' => $this->social_links,
            'profile_image_path' => $this->profile_image_path,
        ];

        if ($this->show_email_publicly) {
            $data['email'] = $this->email;
        }

        if ($this->show_phone_publicly) {
            $data['phone'] = $this->phone;
        }

        return array_filter($data, fn($value) => !is_null($value));
    }

    /**
     * Check if user has a complete public profile.
     */
    public function hasCompletePublicProfile(): bool
    {
        return $this->show_profile_publicly && 
               !empty($this->bio) && 
               !empty($this->name);
    }

    /**
     * Get profile image URL.
     */
    public function getProfileImageUrl(): string
    {
        if ($this->profile_image_path) {
            return Storage::url($this->profile_image_path);
        }

        // Default avatar
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Get the subscriptions for this user.
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Get the wallet for this user.
     */
    public function wallet()
    {
        return $this->morphOne(Wallet::class, 'owner');
    }

    /**
     * Get sent messages for this user.
     */
    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * Get received messages for this user.
     */
    public function receivedMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    /**
     * Get all messages for this user (sent and received).
     */
    public function messages(): HasMany
    {
        return $this->sentMessages()->union($this->receivedMessages());
    }

    /**
     * Get unread messages for this user.
     */
    public function unreadMessages(): HasMany
    {
        return $this->receivedMessages()->where('is_read', false);
    }
}
