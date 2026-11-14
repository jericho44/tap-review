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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique('uq_clients_uuid');
            $table->foreignId('tenant_id')->constrained('tenants')->restrictOnDelete();
            $table->foreignId('theme_id')->nullable()->constrained('themes')->restrictOnDelete();
            $table->string('business_name', 255);
            $table->string('category', 100)->nullable();
            $table->string('contact_name', 255);
            $table->string('email', 255);
            $table->string('whatsapp', 50);
            $table->text('address')->nullable();
            $table->string('slug', 100);
            $table->text('google_review_url');
            $table->string('status', 32)->default('active'); // active, inactive, suspended
            $table->string('package_plan', 50)->default('starter');
            $table->timestamp('active_until')->nullable();
            $table->jsonb('metadata')->default('{}');

            // Standard DB-20 columns
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['tenant_id', 'status'], 'idx_clients_tenant_status');
        });

        // Partial unique index for client slug (DB-44)
        DB::statement('CREATE UNIQUE INDEX uq_clients_slug ON clients(slug) WHERE deleted_at IS NULL;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
