<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tenants Table (DB-80)
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique('uq_tenants_uuid');
            $table->string('name', 255);
            $table->string('slug', 100);
            $table->string('status', 32)->default('active'); // active, suspended, cancelled (DB-51 no ENUM)
            $table->timestamps();
            $table->softDeletes();
        });

        // Partial unique index for soft-deletable slug (DB-44)
        DB::statement('CREATE UNIQUE INDEX uq_tenants_slug ON tenants(slug) WHERE deleted_at IS NULL;');

        // 2. Users Table
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique('uq_users_uuid');
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->restrictOnDelete();
            $table->string('name', 255);
            $table->string('email', 255);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 255)->nullable();
            $table->string('role', 32)->default('client_manager'); // super_admin, admin_staff, client_owner, client_manager
            $table->string('two_factor_secret', 255)->nullable();
            $table->boolean('two_factor_enabled')->default(false);
            $table->rememberToken();

            // Standard DB-20 columns
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['tenant_id', 'role'], 'idx_users_tenant_role');
        });

        // Partial unique index for soft-deletable user email (DB-44)
        DB::statement('CREATE UNIQUE INDEX uq_users_tenant_email ON users(tenant_id, email) WHERE deleted_at IS NULL;');

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
        Schema::dropIfExists('tenants');
    }
};
