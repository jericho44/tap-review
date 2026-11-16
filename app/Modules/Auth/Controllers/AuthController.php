<?php

namespace App\Modules\Auth\Controllers;

use App\Core\Http\Responses\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Client\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Authenticate user with email and password.
     */
    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Find user by email without tenant scope (auth context)
        $user = User::withoutGlobalScopes()->where('email', $validated['email'])->first();

        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            return ApiResponse::error(
                message: 'Kombinasi email atau password salah.',
                statusCode: 401,
                errorCode: 'AUTH_INVALID_CREDENTIALS'
            );
        }

        // Find associated client profile if user is client
        $client = null;
        if ($user->tenant_id) {
            $client = Client::withoutGlobalScopes()->where('tenant_id', $user->tenant_id)->first();
        }

        // Revoke old tokens & create new token
        $user->tokens()->delete();
        $token = $user->createToken('auth-token')->plainTextToken;

        return ApiResponse::success([
            'token' => $token,
            'user' => [
                'uuid' => $user->uuid,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'tenant_id' => $user->tenant_id,
                'business_name' => $client?->business_name ?? null,
                'client_slug' => $client?->slug ?? null,
            ],
        ], 'Login berhasil.');
    }

    /**
     * Get currently authenticated user details.
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->user();

        $client = null;
        if ($user->tenant_id) {
            $client = Client::withoutGlobalScopes()->where('tenant_id', $user->tenant_id)->first();
        }

        return ApiResponse::success([
            'uuid' => $user->uuid,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'tenant_id' => $user->tenant_id,
            'business_name' => $client?->business_name ?? null,
            'client_slug' => $client?->slug ?? null,
        ]);
    }

    /**
     * Logout and revoke active token.
     */
    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user && $user->currentAccessToken()) {
            $user->currentAccessToken()->delete();
        }

        return ApiResponse::success([], 'Sesi berhasil diakhiri.');
    }
}
