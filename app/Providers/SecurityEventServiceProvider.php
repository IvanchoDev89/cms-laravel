<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class SecurityEventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        \Illuminate\Auth\Events\Login::class => [
            \App\Listeners\LogSecurityEvents::class,
        ],
        \Illuminate\Auth\Events\Logout::class => [
            \App\Listeners\LogSecurityEvents::class,
        ],
        \Illuminate\Auth\Events\Failed::class => [
            \App\Listeners\LogSecurityEvents::class,
        ],
        \Illuminate\Auth\Events\Lockout::class => [
            \App\Listeners\LogSecurityEvents::class,
        ],
        \Illuminate\Auth\Events\PasswordReset::class => [
            \App\Listeners\LogSecurityEvents::class,
        ],
        \Illuminate\Auth\Events\Registered::class => [
            \App\Listeners\LogSecurityEvents::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }
}
