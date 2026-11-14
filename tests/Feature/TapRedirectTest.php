<?php

namespace Tests\Feature;

use App\Modules\Client\Models\Client;
use App\Modules\Point\Models\Point;
use App\Modules\Tap\Jobs\RecordTapJob;
use App\Modules\Tap\Models\Tap;
use App\Modules\Tenant\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Str;
use Tests\TestCase;

class TapRedirectTest extends TestCase
{
    use RefreshDatabase;

    public function test_active_client_redirects_302_and_dispatches_tap_job(): void
    {
        Queue::fake();

        $tenant = Tenant::create([
            'uuid' => (string) Str::uuid(),
            'name' => 'Kopi Sudut Tenant',
            'slug' => 'kopi-tenant',
            'status' => 'active',
        ]);

        $client = Client::create([
            'uuid' => (string) Str::uuid(),
            'tenant_id' => $tenant->id,
            'business_name' => 'Kopi Sudut',
            'contact_name' => 'Budi Santoso',
            'email' => 'budi@kopisudut.com',
            'whatsapp' => '081234567890',
            'slug' => 'kopisudut',
            'google_review_url' => 'https://maps.app.goo.gl/kopi-sudut-official',
            'status' => 'active',
        ]);

        Point::create([
            'uuid' => (string) Str::uuid(),
            'tenant_id' => $tenant->id,
            'client_id' => $client->id,
            'point_code' => 'KPS-001',
            'location_label' => 'Meja Kasir',
            'chip_status' => 'locked',
            'physical_status' => 'installed',
        ]);

        // Hit redirect route with NFC query param
        $response = $this->get('/r/kopisudut?src=nfc&p=KPS-001');

        $response->assertStatus(302);
        $response->assertRedirect('https://maps.app.goo.gl/kopi-sudut-official');

        // Verify RecordTapJob was pushed to queue
        Queue::assertPushed(RecordTapJob::class, function (RecordTapJob $job) {
            return $job->tapPayload['client_slug'] === 'kopisudut'
                && $job->tapPayload['source_type'] === 'nfc'
                && $job->tapPayload['point_code'] === 'KPS-001';
        });
    }

    public function test_record_tap_job_inserts_analytics_record_in_taps_table(): void
    {
        $tenant = Tenant::create([
            'uuid' => (string) Str::uuid(),
            'name' => 'Kopi Sudut Tenant',
            'slug' => 'kopi-tenant-2',
            'status' => 'active',
        ]);

        $client = Client::create([
            'uuid' => (string) Str::uuid(),
            'tenant_id' => $tenant->id,
            'business_name' => 'Kopi Sudut',
            'contact_name' => 'Budi Santoso',
            'email' => 'budi2@kopisudut.com',
            'whatsapp' => '081234567890',
            'slug' => 'kopisudut',
            'google_review_url' => 'https://maps.app.goo.gl/kopi-sudut-official',
            'status' => 'active',
        ]);

        $point = Point::create([
            'uuid' => (string) Str::uuid(),
            'tenant_id' => $tenant->id,
            'client_id' => $client->id,
            'point_code' => 'KPS-002',
            'location_label' => 'Meja Makan 02',
            'chip_status' => 'locked',
            'physical_status' => 'installed',
        ]);

        $job = new RecordTapJob([
            'client_slug' => 'kopisudut',
            'source_type' => 'qr',
            'point_code' => 'KPS-002',
            'user_agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.0 Mobile/15E148 Safari/604.1',
            'tapped_at' => now('UTC'),
        ]);

        $job->handle();

        $this->assertDatabaseHas('taps', [
            'tenant_id' => $tenant->id,
            'point_id' => $point->id,
            'source_type' => 'qr',
            'device_family' => 'iPhone',
            'platform' => 'iOS',
            'browser' => 'Safari',
        ]);
    }

    public function test_inactive_client_shows_neutral_page_without_error(): void
    {
        $tenant = Tenant::create([
            'uuid' => (string) Str::uuid(),
            'name' => 'Inactive Tenant',
            'slug' => 'inactive-tenant',
            'status' => 'active',
        ]);

        Client::create([
            'uuid' => (string) Str::uuid(),
            'tenant_id' => $tenant->id,
            'business_name' => 'Toko Tutup',
            'contact_name' => 'Pak Budi',
            'email' => 'tutup@toko.com',
            'whatsapp' => '081234567890',
            'slug' => 'tokotutup',
            'google_review_url' => 'https://maps.app.goo.gl/toko-tutup',
            'status' => 'suspended', // Suspended / inactive
        ]);

        $response = $this->get('/r/tokotutup');

        $response->assertStatus(200);
        $response->assertSee('Toko Tutup');
        $response->assertSee('Buka di Google Maps');
    }
}
