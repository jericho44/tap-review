<?php

namespace App\Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class RequestIdMiddleware
{
    /**
     * Handle an incoming request and ensure X-Request-ID header exists.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $requestId = $request->header('X-Request-ID');

        if (! $requestId || ! Str::isUuid($requestId)) {
            $requestId = (string) Str::uuid();
            $request->headers->set('X-Request-ID', $requestId);
        }

        $response = $next($request);

        $response->headers->set('X-Request-ID', $requestId);

        return $response;
    }
}
