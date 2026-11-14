<?php

namespace App\Modules\Tap\Services;

use App\Core\Services\BaseService;
use App\Modules\Client\Models\Client;
use App\Modules\Tap\DTOs\TapData;
use App\Modules\Tap\Jobs\RecordTapJob;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class RedirectService extends BaseService
{
    /**
     * Handle the fast redirect flow for NFC and QR scans.
     */
    public function handle(string $slug, Request $request): RedirectResponse|Response
    {
        $sourceType = $request->query('src', 'nfc');
        $pointCode = $request->query('p');
        $userAgent = $request->userAgent();
        $requestId = $request->header('X-Request-ID');

        // 1. Create Tap Data DTO
        $tapData = TapData::fromRequest(
            clientSlug: $slug,
            sourceType: $sourceType,
            pointCode: $pointCode,
            userAgent: $userAgent,
            requestId: $requestId
        );

        // 2. Dispatch tap recording asynchronously to database queue (CODE-09, CODE-12)
        RecordTapJob::dispatch($tapData->toArray());

        // 3. Cache client redirect data (TTL: 5 minutes) to ensure <100ms response
        $cacheKey = "client_redirect_{$slug}";
        $clientData = Cache::remember($cacheKey, 300, function () use ($slug) {
            $client = Client::withoutGlobalScopes()->where('slug', $slug)->first();

            if (! $client) {
                return null;
            }

            return [
                'business_name' => $client->business_name,
                'google_review_url' => $client->google_review_url,
                'status' => $client->status,
                'active_until' => $client->active_until?->toIso8601ZuluString(),
            ];
        });

        // 4. Fallback if client does not exist
        if (! $clientData) {
            return response()->view('neutral_redirect', [
                'client' => (object) ['business_name' => 'Lokasi Bisnis'],
                'googleReviewUrl' => 'https://maps.google.com',
            ], 200);
        }

        // 5. If client is inactive or expired, show neutral friendly page per spec
        if ($clientData['status'] !== 'active') {
            return response()->view('neutral_redirect', [
                'client' => (object) $clientData,
                'googleReviewUrl' => $clientData['google_review_url'],
            ], 200);
        }

        // 6. Fast Redirect (HTTP 302 Found) to verified Google Review URL
        return redirect()->away($clientData['google_review_url'], 302);
    }

    /**
     * Clear cached redirect info when a client updates destination URL.
     */
    public function clearCache(string $slug): void
    {
        Cache::forget("client_redirect_{$slug}");
    }
}
