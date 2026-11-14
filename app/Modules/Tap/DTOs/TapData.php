<?php

namespace App\Modules\Tap\DTOs;

use Illuminate\Support\Carbon;

class TapData
{
    public function __construct(
        public readonly string $clientSlug,
        public readonly string $sourceType,
        public readonly ?string $pointCode = null,
        public readonly ?string $userAgent = null,
        public readonly ?Carbon $tappedAt = null,
        public readonly ?string $requestId = null,
    ) {}

    public static function fromRequest(
        string $clientSlug,
        string $sourceType,
        ?string $pointCode,
        ?string $userAgent,
        ?string $requestId = null
    ): self {
        $normalizedSource = strtolower($sourceType) === 'qr' ? 'qr' : 'nfc';

        return new self(
            clientSlug: $clientSlug,
            sourceType: $normalizedSource,
            pointCode: $pointCode,
            userAgent: $userAgent,
            tappedAt: Carbon::now('UTC'),
            requestId: $requestId
        );
    }

    public function toArray(): array
    {
        return [
            'client_slug' => $this->clientSlug,
            'source_type' => $this->sourceType,
            'point_code' => $this->pointCode,
            'user_agent' => $this->userAgent,
            'tapped_at' => $this->tappedAt?->toIso8601ZuluString(),
            'request_id' => $this->requestId,
        ];
    }
}
