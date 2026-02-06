<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only add headers to actual responses, not to Livewire component responses
        if (! $this->isLivewireRequest($request) && $response instanceof Response) {
            // Prevent clickjacking
            $response->headers->set('X-Frame-Options', 'DENY');

            // Prevent MIME type sniffing
            $response->headers->set('X-Content-Type-Options', 'nosniff');

            // Enable XSS protection
            $response->headers->set('X-XSS-Protection', '1; mode=block');

            // Referrer Policy
            $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

            // Remove server information
            $response->headers->set('Server', '');
            $response->headers->remove('X-Powered-By');

            // Strict Transport Security (only in production with HTTPS)
            if (app()->environment('production') && $request->secure()) {
                $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
            }
        }

        return $response;
    }

    /**
     * Check if this is a Livewire request.
     */
    private function isLivewireRequest(Request $request): bool
    {
        return $request->hasHeader('X-Livewire') ||
               $request->is('livewire/*') ||
               str_contains($request->path(), 'livewire');
    }
}
