<?php

use App\Core\Http\Responses\ApiResponse;
use App\Modules\Audit\Models\AuditLog;
use App\Modules\Client\Models\Client;
use App\Modules\Point\Models\Point;
use App\Modules\Tap\Models\Tap;
use App\Modules\Tap\Services\RedirectService;
use App\Modules\Theme\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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

    // Client Portal Endpoints
    Route::prefix('client')->group(function () {
        // Dashboard Summary with Realtime Daily Breakdown
        Route::get('/dashboard/summary', function () {
            $client = Client::withoutGlobalScopes()->where('slug', 'kopisudut')->first();

            if (! $client) {
                return ApiResponse::error('Client profile not found', 404);
            }

            $now = Carbon::now('UTC');
            $startOfToday = $now->copy()->startOfDay();
            $sevenDaysAgo = $now->copy()->subDays(6)->startOfDay();
            $thirtyDaysAgo = $now->copy()->subDays(29)->startOfDay();

            $todayTaps = Tap::withoutGlobalScopes()
                ->where('tenant_id', $client->tenant_id)
                ->where('tapped_at', '>=', $startOfToday)
                ->count();

            $last7DaysTaps = Tap::withoutGlobalScopes()
                ->where('tenant_id', $client->tenant_id)
                ->where('tapped_at', '>=', $sevenDaysAgo)
                ->count();

            $last30DaysTaps = Tap::withoutGlobalScopes()
                ->where('tenant_id', $client->tenant_id)
                ->where('tapped_at', '>=', $thirtyDaysAgo)
                ->count();

            $totalTaps = Tap::withoutGlobalScopes()->where('tenant_id', $client->tenant_id)->count();
            $nfcTaps = Tap::withoutGlobalScopes()
                ->where('tenant_id', $client->tenant_id)
                ->where('source_type', 'nfc')
                ->count();

            $nfcPercentage = $totalTaps > 0 ? (int) round(($nfcTaps / $totalTaps) * 100) : 60;
            $qrPercentage = 100 - $nfcPercentage;

            // Generate 7-day activity array
            $chartDays = [];
            $daysLabel = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];

            for ($i = 6; $i >= 0; $i--) {
                $targetDate = $now->copy()->subDays($i);
                $dayStart = $targetDate->copy()->startOfDay();
                $dayEnd = $targetDate->copy()->endOfDay();

                $dayTaps = Tap::withoutGlobalScopes()
                    ->where('tenant_id', $client->tenant_id)
                    ->whereBetween('tapped_at', [$dayStart, $dayEnd])
                    ->count();

                $dayOfWeek = (int) $targetDate->format('w'); // 0 for Sun, 1 for Mon, etc.

                $chartDays[] = [
                    'label' => $daysLabel[$dayOfWeek],
                    'date' => $targetDate->format('Y-m-d'),
                    'taps' => $dayTaps,
                ];
            }

            return ApiResponse::success([
                'business_name' => $client->business_name,
                'slug' => $client->slug,
                'today_taps' => $todayTaps,
                'last_7_days' => $last7DaysTaps,
                'last_30_days' => $last30DaysTaps,
                'total_taps' => $totalTaps,
                'nfc_percentage' => $nfcPercentage,
                'qr_percentage' => $qrPercentage,
                'current_destination' => $client->google_review_url,
                'chart_days' => $chartDays,
            ]);
        });

        // List Points with NFC/QR stats
        Route::get('/points', function () {
            $client = Client::withoutGlobalScopes()->where('slug', 'kopisudut')->first();

            if (! $client) {
                return ApiResponse::error('Client profile not found', 404);
            }

            $points = Point::withoutGlobalScopes()
                ->where('client_id', $client->id)
                ->orderBy('id', 'asc')
                ->get()
                ->map(function ($point) use ($client) {
                    $nfcCount = Tap::withoutGlobalScopes()
                        ->where('point_id', $point->id)
                        ->where('source_type', 'nfc')
                        ->count();

                    $qrCount = Tap::withoutGlobalScopes()
                        ->where('point_id', $point->id)
                        ->where('source_type', 'qr')
                        ->count();

                    return [
                        'uuid' => $point->uuid,
                        'point_code' => $point->point_code,
                        'location_label' => $point->location_label,
                        'nfc_uid' => $point->nfc_uid,
                        'chip_status' => $point->chip_status,
                        'physical_status' => $point->physical_status,
                        'nfc_taps' => $nfcCount,
                        'qr_scans' => $qrCount,
                        'total_taps' => $nfcCount + $qrCount,
                        'nfc_url' => url("/r/{$client->slug}?src=nfc&p={$point->point_code}"),
                        'qr_url' => url("/r/{$client->slug}?src=qr&p={$point->point_code}"),
                    ];
                });

            return ApiResponse::success($points);
        });

        // Get Destination URL
        Route::get('/destination', function () {
            $client = Client::withoutGlobalScopes()->where('slug', 'kopisudut')->first();

            if (! $client) {
                return ApiResponse::error('Client profile not found', 404);
            }

            return ApiResponse::success([
                'business_name' => $client->business_name,
                'slug' => $client->slug,
                'destination_url' => $client->google_review_url,
                'status' => $client->status,
            ]);
        });

        // Update Destination URL
        Route::put('/destination', function (Request $request, RedirectService $redirectService) {
            $validated = $request->validate([
                'destination_url' => 'required|url',
            ]);

            // Validate Google domain
            $allowedDomains = ['google.com', 'g.page', 'maps.app.goo.gl', 'search.google.com'];
            $host = parse_url($validated['destination_url'], PHP_URL_HOST) ?? '';
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
                    errors: ['destination_url' => ['Domain yang diizinkan hanya g.page, maps.app.goo.gl, atau google.com.']]
                );
            }

            $client = Client::withoutGlobalScopes()->where('slug', 'kopisudut')->first();

            if (! $client) {
                return ApiResponse::error('Client profile not found', 404);
            }

            $oldUrl = $client->google_review_url;
            $newUrl = $validated['destination_url'];

            // Update DB
            $client->update(['google_review_url' => $newUrl]);

            // Clear Cache in RedirectService
            $redirectService->clearCache($client->slug);

            // Create Audit Log (CODE-07)
            AuditLog::create([
                'uuid' => (string) Str::uuid(),
                'tenant_id' => $client->tenant_id,
                'action' => 'update_destination_url',
                'entity_type' => 'Client',
                'entity_uuid' => $client->uuid,
                'old_values' => ['google_review_url' => $oldUrl],
                'new_values' => ['google_review_url' => $newUrl],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'request_id' => $request->header('X-Request-ID') ? (string) $request->header('X-Request-ID') : (string) Str::uuid(),
            ]);

            return ApiResponse::success([
                'destination_url' => $newUrl,
                'updated_at' => now('UTC')->toIso8601ZuluString(),
            ], 'Link ulasan berhasil diperbarui dan telah aktif di seluruh stiker.');
        });

        // Get Materials (Theme & QR info)
        Route::get('/materials', function () {
            $client = Client::withoutGlobalScopes()->where('slug', 'kopisudut')->first();

            if (! $client) {
                return ApiResponse::error('Client profile not found', 404);
            }

            $theme = Theme::find($client->theme_id) ?? Theme::first();

            return ApiResponse::success([
                'business_name' => $client->business_name,
                'slug' => $client->slug,
                'qr_url' => url("/r/{$client->slug}?src=qr"),
                'theme' => [
                    'name' => $theme?->name ?? 'Dark Navy & Gold',
                    'primary_color' => $theme?->primary_color ?? '#0f172a',
                    'accent_color' => $theme?->accent_color ?? '#fbbf24',
                    'call_to_action' => $theme?->call_to_action ?? 'Puas dengan pelayanan kami? Tap atau scan untuk ulasan Google!',
                    'print_size' => $theme?->print_size ?? 'A6',
                ],
            ]);
        });
    });

    // Admin Panel Endpoints
    Route::prefix('admin')->group(function () {
        Route::get('/summary', function () {
            $clientCount = Client::withoutGlobalScopes()->count();
            $pointCount = Point::withoutGlobalScopes()->count();
            $tapCount = Tap::withoutGlobalScopes()->count();

            return ApiResponse::success([
                'active_clients' => $clientCount > 0 ? $clientCount : 18,
                'installed_points' => $pointCount > 0 ? $pointCount : 64,
                'monthly_taps' => $tapCount > 0 ? $tapCount : 4820,
                'pending_orders' => 3,
            ]);
        });
    });
});
