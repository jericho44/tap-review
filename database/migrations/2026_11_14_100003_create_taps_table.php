<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('taps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('tenants')->restrictOnDelete();
            $table->foreignId('point_id')->constrained('points')->restrictOnDelete();
            $table->string('source_type', 16); // 'nfc' or 'qr'
            $table->string('device_family', 50)->nullable();
            $table->string('platform', 50)->nullable();
            $table->string('browser', 50)->nullable();
            $table->timestamp('tapped_at')->useCurrent();

            $table->index(['tenant_id', 'point_id', 'tapped_at'], 'idx_taps_tenant_point_time');
            $table->index(['point_id', 'source_type'], 'idx_taps_point_source');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taps');
    }
};
