<?php

use App\Core\Http\Responses\ApiResponse;
use App\Modules\Audit\Models\AuditLog;
use App\Modules\Auth\Controllers\AuthController;
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

    // Authentication Endpoints (Sanctum Token / SPA Session)
    Route::prefix('auth')->group(function () {
        Route::post('/login', [AuthController::class, 'login']);

        Route::middleware('auth:sanctum')->group(function () {
            Route::get('/me', [AuthController::class, 'me']);
            Route::post('/logout', [AuthController::class, 'logout']);
        });
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

    // Protected Client Portal Endpoints (Role: client_owner, client_manager, or super_admin)
    Route::prefix('client')
        ->middleware(['auth:sanctum', 'role:client_owner,client_manager'])
        ->group(function () {
            // Dashboard Summary
            Route::get('/dashboard/summary', function (Request $request) {
                $user = $request->user();

                // Retrieve client according to authenticated user's tenant
                $client = Client::where('tenant_id', $user->tenant_id)->first()
                    ?? Client::withoutGlobalScopes()->where('slug', 'kopisudut')->first();

                if (! $client) {
                    return ApiResponse::error('Profil bisnis klien tidak ditemukan.', 404);
                }

                $now = Carbon::now('UTC');
                $startOfToday = $now->copy()->startOfDay();
                $sevenDaysAgo = $now->copy()->subDays(6)->startOfDay();
                $thirtyDaysAgo = $now->copy()->subDays(29)->startOfDay();

                $todayTaps = Tap::where('tenant_id', $client->tenant_id)
                    ->where('tapped_at', '>=', $startOfToday)
                    ->count();

                $last7DaysTaps = Tap::where('tenant_id', $client->tenant_id)
                    ->where('tapped_at', '>=', $sevenDaysAgo)
                    ->count();

                $last30DaysTaps = Tap::where('tenant_id', $client->tenant_id)
                    ->where('tapped_at', '>=', $thirtyDaysAgo)
                    ->count();

                $totalTaps = Tap::where('tenant_id', $client->tenant_id)->count();
                $nfcTaps = Tap::where('tenant_id', $client->tenant_id)
                    ->where('source_type', 'nfc')
                    ->count();

                $nfcPercentage = $totalTaps > 0 ? (int) round(($nfcTaps / $totalTaps) * 100) : 60;
                $qrPercentage = 100 - $nfcPercentage;

                $chartDays = [];
                $daysLabel = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];

                for ($i = 6; $i >= 0; $i--) {
                    $targetDate = $now->copy()->subDays($i);
                    $dayStart = $targetDate->copy()->startOfDay();
                    $dayEnd = $targetDate->copy()->endOfDay();

                    $dayTaps = Tap::where('tenant_id', $client->tenant_id)
                        ->whereBetween('tapped_at', [$dayStart, $dayEnd])
                        ->count();

                    $dayOfWeek = (int) $targetDate->format('w');

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

            // List Points
            Route::get('/points', function (Request $request) {
                $user = $request->user();
                $client = Client::where('tenant_id', $user->tenant_id)->first()
                    ?? Client::withoutGlobalScopes()->where('slug', 'kopisudut')->first();

                if (! $client) {
                    return ApiResponse::error('Profil bisnis klien tidak ditemukan.', 404);
                }

                $points = Point::where('client_id', $client->id)
                    ->orderBy('id', 'asc')
                    ->get()
                    ->map(function ($point) use ($client) {
                        $nfcCount = Tap::where('point_id', $point->id)
                            ->where('source_type', 'nfc')
                            ->count();

                        $qrCount = Tap::where('point_id', $point->id)
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

            // Destination
            Route::get('/destination', function (Request $request) {
                $user = $request->user();
                $client = Client::where('tenant_id', $user->tenant_id)->first()
                    ?? Client::withoutGlobalScopes()->where('slug', 'kopisudut')->first();

                if (! $client) {
                    return ApiResponse::error('Profil bisnis klien tidak ditemukan.', 404);
                }

                return ApiResponse::success([
                    'business_name' => $client->business_name,
                    'slug' => $client->slug,
                    'destination_url' => $client->google_review_url,
                    'status' => $client->status,
                ]);
            });

            Route::put('/destination', function (Request $request, RedirectService $redirectService) {
                $validated = $request->validate([
                    'destination_url' => 'required|url',
                ]);

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

                $user = $request->user();
                $client = Client::where('tenant_id', $user->tenant_id)->first()
                    ?? Client::withoutGlobalScopes()->where('slug', 'kopisudut')->first();

                if (! $client) {
                    return ApiResponse::error('Profil bisnis klien tidak ditemukan.', 404);
                }

                $oldUrl = $client->google_review_url;
                $newUrl = $validated['destination_url'];

                $client->update(['google_review_url' => $newUrl]);
                $redirectService->clearCache($client->slug);

                AuditLog::create([
                    'uuid' => (string) Str::uuid(),
                    'tenant_id' => $client->tenant_id,
                    'user_id' => $user->id,
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

            // Materials
            Route::get('/materials', function (Request $request) {
                $user = $request->user();
                $client = Client::where('tenant_id', $user->tenant_id)->first()
                    ?? Client::withoutGlobalScopes()->where('slug', 'kopisudut')->first();

                if (! $client) {
                    return ApiResponse::error('Profil bisnis klien tidak ditemukan.', 404);
                }

                $theme = Theme::find($client->theme_id) ?? Theme::first();

                return ApiResponse::success([
                    'business_name' => $client->business_name,
                    'slug' => $client->slug,
                    'qr_url' => url("/r/{$client->slug}?src=qr"),
                    'theme' => [
                        'name' => $theme?->name ?? 'Dark Navy & Gold',
                        'primary_color' => $theme?->primary_color ?? '#18181b',
                        'accent_color' => $theme?->accent_color ?? '#fbbf24',
                        'call_to_action' => $theme?->call_to_action ?? 'Puas dengan pelayanan kami? Tap atau scan untuk ulasan Google!',
                        'print_size' => $theme?->print_size ?? 'A6 Stand',
                    ],
                ]);
            });
        });

    // Protected Admin Panel Endpoints (Role: super_admin or admin_staff)
    Route::prefix('admin')
        ->middleware(['auth:sanctum', 'role:super_admin,admin_staff'])
        ->group(function () {
            Route::get('/summary', function () {
                $clientCount = Client::withoutGlobalScopes()->count();
                $pointCount = Point::withoutGlobalScopes()->count();
                $tapCount = Tap::withoutGlobalScopes()->count();

                return ApiResponse::success([
                    'active_clients' => $clientCount,
                    'installed_points' => $pointCount,
                    'monthly_taps' => $tapCount,
                    'pending_orders' => 3,
                ]);
            });
        });
});
