<?php

namespace Tests\Feature;

use App\Models\User;
use App\Modules\Client\Models\Client;
use App\Modules\Tenant\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected Tenant $tenant;
    protected User $clientUser;
    protected User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tenant = Tenant::create([
            'uuid' => (string) Str::uuid(),
            'name' => 'Kopi Sudut',
            'slug' => 'kopisudut',
            'status' => 'active',
        ]);

        $this->clientUser = User::create([
            'uuid' => (string) Str::uuid(),
            'tenant_id' => $this->tenant->id,
            'name' => 'Budi Santoso',
            'email' => 'owner@kopisudut.com',
            'password' => Hash::make('password123'),
            'role' => 'client_owner',
        ]);

        Client::create([
            'uuid' => (string) Str::uuid(),
            'tenant_id' => $this->tenant->id,
            'business_name' => 'Kopi Sudut',
            'contact_name' => 'Budi Santoso',
            'email' => 'owner@kopisudut.com',
            'whatsapp' => '081234567890',
            'slug' => 'kopisudut',
            'google_review_url' => 'https://maps.app.goo.gl/kopi-sudut',
            'status' => 'active',
        ]);

        $this->adminUser = User::create([
            'uuid' => (string) Str::uuid(),
            'tenant_id' => null,
            'name' => 'Super Administrator',
            'email' => 'superadmin@tapreview.id',
            'password' => Hash::make('password123'),
            'role' => 'super_admin',
        ]);
    }

    public function test_login_with_valid_credentials_returns_token(): void
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'owner@kopisudut.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'token',
                    'user' => ['uuid', 'name', 'email', 'role', 'business_name'],
                ],
                'meta' => ['request_id', 'timestamp'],
            ])
            ->assertJson([
                'success' => true,
                'data' => [
                    'user' => [
                        'email' => 'owner@kopisudut.com',
                        'role' => 'client_owner',
                        'business_name' => 'Kopi Sudut',
                    ],
                ],
            ]);
    }

    public function test_login_with_invalid_password_returns_401(): void
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'owner@kopisudut.com',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'success' => false,
                'message' => 'Kombinasi email atau password salah.',
            ]);
    }

    public function test_unauthenticated_request_to_client_portal_returns_401(): void
    {
        $response = $this->getJson('/api/v1/client/dashboard/summary');

        $response->assertStatus(401);
    }

    public function test_client_cannot_access_admin_endpoints(): void
    {
        $token = $this->clientUser->createToken('test')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer '.$token)
            ->getJson('/api/v1/admin/summary');

        $response->assertStatus(403)
            ->assertJson([
                'success' => false,
                'message' => 'Akses ditolak. Anda tidak memiliki izin untuk modul ini.',
            ]);
    }

    public function test_admin_can_access_admin_endpoints(): void
    {
        $token = $this->adminUser->createToken('test')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer '.$token)
            ->getJson('/api/v1/admin/summary');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
    }

    public function test_logout_revokes_token(): void
    {
        $token = $this->clientUser->createToken('test')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer '.$token)
            ->postJson('/api/v1/auth/logout');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Sesi berhasil diakhiri.',
            ]);

        // Attempting to access protected route with revoked token should fail
        $check = $this->withHeader('Authorization', 'Bearer '.$token)
            ->getJson('/api/v1/client/dashboard/summary');

        $check->assertStatus(401);
    }
}

