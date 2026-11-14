<?php

namespace Database\Seeders;

use App\Models\User;
use App\Modules\Audit\Models\AuditLog;
use App\Modules\Client\Models\Client;
use App\Modules\Point\Models\Point;
use App\Modules\Tenant\Models\Tenant;
use App\Modules\Theme\Models\Theme;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database. Idempotent (DB-72).
     */
    public function run(): void
    {
        // 1. Seed Master Themes
        $darkTheme = Theme::firstOrCreate(
            ['name' => 'Dark Navy & Gold'],
            [
                'uuid' => (string) Str::uuid(),
                'primary_color' => '#0f172a',
                'accent_color' => '#fbbf24',
                'call_to_action' => 'Puas dengan pelayanan kami? Tap atau scan untuk ulasan Google!',
                'print_size' => 'A6',
                'style_config' => ['font' => 'Inter', 'rounded' => '2xl'],
                'is_active' => true,
            ]
        );

        Theme::firstOrCreate(
            ['name' => 'Pure Minimalist Light'],
            [
                'uuid' => (string) Str::uuid(),
                'primary_color' => '#f8fafc',
                'accent_color' => '#0f172a',
                'call_to_action' => 'Scan kode QR untuk memberi ulasan di Google Maps',
                'print_size' => 'A6',
                'style_config' => ['font' => 'Inter', 'rounded' => 'xl'],
                'is_active' => true,
            ]
        );

        Theme::firstOrCreate(
            ['name' => 'Coffee Artisan Brown'],
            [
                'uuid' => (string) Str::uuid(),
                'primary_color' => '#451a03',
                'accent_color' => '#fef3c7',
                'call_to_action' => 'Suka kopi kami? Beri bintang 5 di Google Review!',
                'print_size' => 'Round-8cm',
                'style_config' => ['font' => 'Inter', 'rounded' => 'full'],
                'is_active' => true,
            ]
        );

        // 2. Seed Super Admin Tenant & User
        $adminTenant = Tenant::firstOrCreate(
            ['slug' => 'tapreview-internal'],
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'TapReview Platform HQ',
                'status' => 'active',
            ]
        );

        User::firstOrCreate(
            ['email' => 'superadmin@tapreview.id'],
            [
                'uuid' => (string) Str::uuid(),
                'tenant_id' => $adminTenant->id,
                'name' => 'Super Administrator',
                'password' => Hash::make('password123'),
                'role' => 'super_admin',
                'two_factor_enabled' => false,
            ]
        );

        // 3. Seed Demo Client Tenant
        $demoTenant = Tenant::firstOrCreate(
            ['slug' => 'kopisudut'],
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'Kopi Sudut Group',
                'status' => 'active',
            ]
        );

        $owner = User::firstOrCreate(
            ['email' => 'owner@kopisudut.com'],
            [
                'uuid' => (string) Str::uuid(),
                'tenant_id' => $demoTenant->id,
                'name' => 'Budi Santoso',
                'password' => Hash::make('password123'),
                'role' => 'client_owner',
                'two_factor_enabled' => false,
            ]
        );

        // 4. Seed Client Business Profile
        $client = Client::firstOrCreate(
            ['slug' => 'kopisudut'],
            [
                'uuid' => (string) Str::uuid(),
                'tenant_id' => $demoTenant->id,
                'theme_id' => $darkTheme->id,
                'business_name' => 'Kopi Sudut',
                'category' => 'Coffee & Eatery',
                'contact_name' => 'Budi Santoso',
                'email' => 'owner@kopisudut.com',
                'whatsapp' => '081234567890',
                'address' => 'Jl. Trunojoyo No. 25, Bandung',
                'google_review_url' => 'https://maps.app.goo.gl/kopi-sudut-official',
                'status' => 'active',
                'package_plan' => 'cafe_resto',
                'active_until' => now()->addYear(),
                'created_by' => $owner->id,
            ]
        );

        // 5. Seed Points (NFC & QR Stickers)
        $pointsData = [
            ['code' => 'KPS-001', 'label' => 'Meja Kasir Utama', 'uid' => '04:7A:B2:91:3F:80'],
            ['code' => 'KPS-002', 'label' => 'Meja Makan 01 (Indoor)', 'uid' => '04:88:C1:92:4A:81'],
            ['code' => 'KPS-003', 'label' => 'Meja Makan 02 (Indoor)', 'uid' => '04:99:D2:83:5B:82'],
            ['code' => 'KPS-004', 'label' => 'Area Outdoor Depan', 'uid' => '04:AA:E3:74:6C:83'],
        ];

        foreach ($pointsData as $p) {
            Point::firstOrCreate(
                ['point_code' => $p['code']],
                [
                    'uuid' => (string) Str::uuid(),
                    'tenant_id' => $demoTenant->id,
                    'client_id' => $client->id,
                    'custom_theme_id' => $darkTheme->id,
                    'location_label' => $p['label'],
                    'nfc_uid' => $p['uid'],
                    'chip_status' => 'locked',
                    'physical_status' => 'installed',
                    'installed_at' => now()->subDays(10),
                    'created_by' => $owner->id,
                ]
            );
        }

        // 6. Seed Sample Audit Log (CODE-07)
        AuditLog::firstOrCreate(
            ['action' => 'update_destination_url', 'entity_uuid' => $client->uuid],
            [
                'uuid' => (string) Str::uuid(),
                'tenant_id' => $demoTenant->id,
                'user_id' => $owner->id,
                'entity_type' => 'Client',
                'old_values' => ['google_review_url' => 'https://maps.app.goo.gl/kopi-sudut-old'],
                'new_values' => ['google_review_url' => 'https://maps.app.goo.gl/kopi-sudut-official'],
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'request_id' => (string) Str::uuid(),
            ]
        );
    }
}
