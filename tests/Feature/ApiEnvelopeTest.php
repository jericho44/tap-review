<?php

namespace Tests\Feature;

use Tests\TestCase;

class ApiEnvelopeTest extends TestCase
{
    public function test_api_health_endpoint(): void
    {
        $response = $this->getJson('/api/v1/health');

        $response->assertStatus(200);
        $this->assertNotEmpty($response->headers->get('X-Request-ID'));
    }

    public function test_qr_verify_rejects_non_google_domain(): void
    {
        $response = $this->postJson('/api/v1/public/qr/verify', [
            'url' => 'https://example-phishing-site.com',
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'success',
                'message',
                'errors',
                'meta' => ['request_id', 'timestamp'],
            ])
            ->assertJson([
                'success' => false,
            ]);
    }

    public function test_qr_verify_accepts_google_maps_domain(): void
    {
        $response = $this->postJson('/api/v1/public/qr/verify', [
            'url' => 'https://maps.app.goo.gl/kopi-sudut',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => ['valid', 'target_url'],
                'meta' => ['request_id', 'timestamp'],
            ])
            ->assertJson([
                'success' => true,
                'data' => [
                    'valid' => true,
                ],
            ]);
    }
}
