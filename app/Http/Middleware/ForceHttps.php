<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceHttps
{
    public function handle(Request $request, Closure $next): Response
    {
        // Only force HTTPS if the request is NOT already secure
        if (!$request->secure() && !$this->isBehindTrustedProxy($request) && app()->environment('production')) {
            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
    }

    private function isBehindTrustedProxy(Request $request): bool
    {
        // Check for Railway or other proxy headers
        return $request->header('X-Forwarded-Proto') === 'https';
    }
}

