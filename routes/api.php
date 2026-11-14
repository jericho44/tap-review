<?php

use App\Core\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes (TapReview v1)
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {
    // Health Check Endpoint (API-30)
    Route::get('/health', function () {
        return response()->json([
            'status' => 'healthy',
            'version' => '1.0.0',
            'timestamp' => now('UTC')->toIso8601ZuluString(),
        ]);
    });

    // Public Endpoints
    Route::prefix('public')->group(function () {
        Route::post('/orders', function (Request $request) {
            $validated = $request->validate([
                'business_name' => 'required|string|max:255',
                'contact_name' => 'required|string|max:255',
                'whatsapp' => 'required|string|max:50',
                'google_review_url' => 'required|url|max:500',
                'package_plan' => 'required|string',
                'point_count' => 'required|integer|min:1|max:100',
                'shipping_address' => 'required|string|max:1000',
            ]);

            return ApiResponse::success([
                'order_number' => 'ORD-'.date('Ymd').'-'.strtoupper(bin2hex(random_bytes(3))),
                'status' => 'received',
                'details' => $validated,
            ], 'Pesanan Anda berhasil dikirim. Tim kami akan menghubungi via WhatsApp.', 201);
        });

        Route::post('/qr/verify', function (Request $request) {
            $validated = $request->validate([
                'url' => 'required|url',
            ]);

            $allowedDomains = ['google.com', 'g.page', 'maps.app.goo.gl', 'search.google.com'];
            $host = parse_url($validated['url'], PHP_URL_HOST) ?? '';
            $isValid = false;

            foreach ($allowedDomains as $domain) {
                if (str_ends_with(strtolower($host), $domain)) {
                    $isValid = true;
                    break;
                }
            }

            if (! $isValid) {
                return ApiResponse::error(
                    message: 'URL ulasan harus mengarah ke domain resmi Google Maps.',
                    statusCode: 422,
                    errors: ['url' => ['Domain yang diizinkan hanya g.page, maps.app.goo.gl, atau google.com.']]
                );
            }

            return ApiResponse::success([
                'valid' => true,
                'target_url' => $validated['url'],
            ], 'URL resmi Google Maps valid.');
        });
    });

    // Client Portal Endpoints (Mock/Initial API contracts)
    Route::prefix('client')->group(function () {
        Route::get('/dashboard/summary', function () {
            return ApiResponse::success([
                'today_taps' => 28,
                'last_7_days' => 194,
                'last_30_days' => 812,
                'nfc_percentage' => 62,
                'qr_percentage' => 38,
                'current_destination' => 'https://maps.app.goo.gl/kopi-sudut-official',
            ]);
        });

        Route::put('/destination', function (Request $request) {
            $validated = $request->validate([
                'destination_url' => 'required|url',
            ]);

            return ApiResponse::success([
                'destination_url' => $validated['destination_url'],
                'updated_at' => now('UTC')->toIso8601ZuluString(),
            ], 'Link ulasan berhasil diperbarui.');
        });
    });

    // Admin Panel Endpoints
    Route::prefix('admin')->group(function () {
        Route::get('/summary', function () {
            return ApiResponse::success([
                'active_clients' => 18,
                'installed_points' => 64,
                'monthly_taps' => 4820,
                'pending_orders' => 3,
            ]);
        });
    });
});
