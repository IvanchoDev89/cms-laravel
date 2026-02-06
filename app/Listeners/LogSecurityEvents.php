<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Log;

class LogSecurityEvents
{
    /**
     * Handle user login events.
     */
    public function handleLogin(Login $event): void
    {
        Log::info('User logged in', [
            'user_id' => $event->user->id,
            'email' => $event->user->email,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'guard' => $event->guard,
            'remember' => $event->remember,
        ]);
    }

    /**
     * Handle user logout events.
     */
    public function handleLogout(Logout $event): void
    {
        Log::info('User logged out', [
            'user_id' => $event->user->id,
            'email' => $event->user->email,
            'ip' => request()->ip(),
            'guard' => $event->guard,
        ]);
    }

    /**
     * Handle failed login events.
     */
    public function handleFailed(Failed $event): void
    {
        Log::warning('Login failed', [
            'email' => $event->credentials['email'] ?? 'unknown',
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'guard' => $event->guard,
        ]);
    }

    /**
     * Handle lockout events.
     */
    public function handleLockout(Lockout $event): void
    {
        Log::warning('User locked out', [
            'email' => $event->request->email,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Handle password reset events.
     */
    public function handlePasswordReset(PasswordReset $event): void
    {
        Log::info('Password reset', [
            'user_id' => $event->user->id,
            'email' => $event->user->email,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Handle user registration events.
     */
    public function handleRegistered(Registered $event): void
    {
        Log::info('User registered', [
            'user_id' => $event->user->id,
            'email' => $event->user->email,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Handle the event.
     */
    public function __invoke($event): void
    {
        // Handle different event types
        if ($event instanceof Login) {
            $this->handleLogin($event);
        } elseif ($event instanceof Logout) {
            $this->handleLogout($event);
        } elseif ($event instanceof Failed) {
            $this->handleFailed($event);
        } elseif ($event instanceof Lockout) {
            $this->handleLockout($event);
        } elseif ($event instanceof PasswordReset) {
            $this->handlePasswordReset($event);
        } elseif ($event instanceof Registered) {
            $this->handleRegistered($event);
        }
    }

    /**
     * Register listeners for subscriber.
     */
    public function subscribe($events): void
    {
        $events->listen(Login::class, [self::class, 'handleLogin']);
        $events->listen(Logout::class, [self::class, 'handleLogout']);
        $events->listen(Failed::class, [self::class, 'handleFailed']);
        $events->listen(Lockout::class, [self::class, 'handleLockout']);
        $events->listen(PasswordReset::class, [self::class, 'handlePasswordReset']);
        $events->listen(Registered::class, [self::class, 'handleRegistered']);
    }
}
