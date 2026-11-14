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
        Schema::create('points', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique('uq_points_uuid');
            $table->foreignId('tenant_id')->constrained('tenants')->restrictOnDelete();
            $table->foreignId('client_id')->constrained('clients')->restrictOnDelete();
            $table->foreignId('custom_theme_id')->nullable()->constrained('themes')->restrictOnDelete();
            $table->string('point_code', 50);
            $table->string('location_label', 150);
            $table->string('nfc_uid', 100)->nullable();
            $table->string('chip_status', 32)->default('unwritten'); // unwritten, written, locked, tested
            $table->string('physical_status', 32)->default('ordered'); // ordered, printed, installed, lost
            $table->timestamp('installed_at')->nullable();

            // Standard DB-20 columns
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['tenant_id', 'client_id'], 'idx_points_client');
        });

        // Partial unique index for point_code (DB-44)
        DB::statement('CREATE UNIQUE INDEX uq_points_code ON points(point_code) WHERE deleted_at IS NULL;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('points');
    }
};
