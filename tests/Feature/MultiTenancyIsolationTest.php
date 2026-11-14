<?php

namespace Tests\Feature;

use App\Models\User;
use App\Modules\Client\Models\Client;
use App\Modules\Point\Models\Point;
use App\Modules\Tenant\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class MultiTenancyIsolationTest extends TestCase
{
    use RefreshDatabase;

    public function test_tenant_data_is_strictly_isolated(): void
    {
        // 1. Create Tenant A & B
        $tenantA = Tenant::create([
            'uuid' => (string) Str::uuid(),
            'name' => 'Kopi Tenant A',
            'slug' => 'kopi-a',
            'status' => 'active',
        ]);

        $tenantB = Tenant::create([
            'uuid' => (string) Str::uuid(),
            'name' => 'Barber Tenant B',
            'slug' => 'barber-b',
            'status' => 'active',
        ]);

        $userA = User::create([
            'uuid' => (string) Str::uuid(),
            'tenant_id' => $tenantA->id,
            'name' => 'User Tenant A',
            'email' => 'user@tenant-a.com',
            'role' => 'client_owner',
        ]);

        $userB = User::create([
            'uuid' => (string) Str::uuid(),
            'tenant_id' => $tenantB->id,
            'name' => 'User Tenant B',
            'email' => 'user@tenant-b.com',
            'role' => 'client_owner',
        ]);

        // 2. Create Clients for each tenant
        $clientA = Client::create([
            'uuid' => (string) Str::uuid(),
            'tenant_id' => $tenantA->id,
            'business_name' => 'Kopi A',
            'contact_name' => 'Manager A',
            'email' => 'contact@kopi-a.com',
            'whatsapp' => '081234567890',
            'slug' => 'kopi-a',
            'google_review_url' => 'https://maps.app.goo.gl/kopi-a',
            'status' => 'active',
        ]);

        $clientB = Client::create([
            'uuid' => (string) Str::uuid(),
            'tenant_id' => $tenantB->id,
            'business_name' => 'Barber B',
            'contact_name' => 'Manager B',
            'email' => 'contact@barber-b.com',
            'whatsapp' => '081234567891',
            'slug' => 'barber-b',
            'google_review_url' => 'https://maps.app.goo.gl/barber-b',
            'status' => 'active',
        ]);

        // 3. Authenticate as User A and verify TenantScope restricts Client queries
        $this->actingAs($userA);

        $visibleClients = Client::all();
        $this->assertCount(1, $visibleClients);
        $this->assertEquals('Kopi A', $visibleClients->first()->business_name);
        $this->assertNull(Client::where('slug', 'barber-b')->first());

        // 4. Authenticate as User B and verify only Tenant B data is returned
        $this->actingAs($userB);

        $visibleClientsB = Client::all();
        $this->assertCount(1, $visibleClientsB);
        $this->assertEquals('Barber B', $visibleClientsB->first()->business_name);
        $this->assertNull(Client::where('slug', 'kopi-a')->first());
    }

    public function test_internal_numeric_id_is_hidden_from_model_serialization(): void
    {
        $tenant = Tenant::create([
            'uuid' => (string) Str::uuid(),
            'name' => 'Test Tenant',
            'slug' => 'test-tenant',
            'status' => 'active',
        ]);

        $serialized = $tenant->toArray();

        $this->assertArrayNotHasKey('id', $serialized, 'Internal numeric id must NEVER be serialized (DB-13).');
        $this->assertArrayHasKey('uuid', $serialized, 'Public uuid must be present.');
    }
}
