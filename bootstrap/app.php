<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withProviders([
        \App\Providers\SecurityEventServiceProvider::class,
    ])
    ->withMiddleware(function (Middleware $middleware): void {
        $webMiddleware = [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\SecurityHeaders::class,
        ];

        // During testing, skip the VerifyCsrfToken middleware to avoid HTTP 419 in test requests.
        if (env('APP_ENV') !== 'testing' && env('APP_ENV') !== 'demo') {
            $webMiddleware[] = \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class;
        }

        $middleware->group('web', $webMiddleware);

        $middleware->alias([
            'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        ]);

        $middleware->group('api', [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:60,1',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Simple error handling for production
        if (! app()->environment('local', 'testing')) {
            $exceptions->render(function (\Throwable $e) {
                if (request()->expectsJson()) {
                    return response()->json([
                        'message' => 'Server Error',
                        'code' => 500,
                    ], 500);
                }

                return response()->view('errors.500', [], 500);
            });
        }
    })->create();
