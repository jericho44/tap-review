<?php

namespace App\Core\Http\Middleware;

use App\Core\Http\Responses\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserRole
{
    /**
     * Handle an incoming request and verify user role (RBAC).
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return ApiResponse::error(
                message: 'Silakan login terlebih dahulu.',
                statusCode: Response::HTTP_UNAUTHORIZED,
                errorCode: 'AUTH_UNAUTHORIZED'
            );
        }

        // Superadmin has universal access
        if ($user->role === 'super_admin') {
            return $next($request);
        }

        if (! in_array($user->role, $roles, true)) {
            return ApiResponse::error(
                message: 'Akses ditolak. Anda tidak memiliki izin untuk modul ini.',
                statusCode: Response::HTTP_FORBIDDEN,
                errorCode: 'AUTH_FORBIDDEN'
            );
        }

        return $next($request);
    }
}
