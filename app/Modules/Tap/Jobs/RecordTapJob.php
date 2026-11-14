<?php

namespace App\Modules\Tap\Jobs;

use App\Modules\Client\Models\Client;
use App\Modules\Point\Models\Point;
use App\Modules\Tap\DTOs\TapData;
use App\Modules\Tap\Models\Tap;
use App\Modules\Tap\Services\UserAgentParser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class RecordTapJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * The number of seconds the job can run before timing out.
     */
    public int $timeout = 30;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly array $tapPayload
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $slug = $this->tapPayload['client_slug'] ?? null;
            $pointCode = $this->tapPayload['point_code'] ?? null;
            $sourceType = $this->tapPayload['source_type'] ?? 'nfc';
            $userAgent = $this->tapPayload['user_agent'] ?? null;
            $tappedAt = $this->tapPayload['tapped_at'] ?? now('UTC');

            if (! $slug) {
                return;
            }

            // Find client without tenant scope since tap requests come from public end users
            $client = Client::withoutGlobalScopes()->where('slug', $slug)->first();

            if (! $client) {
                Log::warning("RecordTapJob: Client not found for slug {$slug}");
                return;
            }

            // Find matching point by code or pick client's default/first point
            $point = null;
            if ($pointCode) {
                $point = Point::withoutGlobalScopes()
                    ->where('client_id', $client->id)
                    ->where('point_code', $pointCode)
                    ->first();
            }

            if (! $point) {
                $point = Point::withoutGlobalScopes()
                    ->where('client_id', $client->id)
                    ->first();
            }

            if (! $point) {
                Log::warning("RecordTapJob: No point configured for client {$client->slug}");
                return;
            }

            // Parse User-Agent
            $deviceInfo = UserAgentParser::parse($userAgent);

            // Record tap event
            Tap::create([
                'tenant_id' => $client->tenant_id,
                'point_id' => $point->id,
                'source_type' => $sourceType,
                'device_family' => $deviceInfo['device_family'],
                'platform' => $deviceInfo['platform'],
                'browser' => $deviceInfo['browser'],
                'tapped_at' => $tappedAt,
            ]);

        } catch (Throwable $e) {
            Log::error('RecordTapJob execution failed: '.$e->getMessage(), [
                'payload' => $this->tapPayload,
                'exception' => $e,
            ]);
            throw $e;
        }
    }
}
