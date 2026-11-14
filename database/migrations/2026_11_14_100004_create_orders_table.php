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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique('uq_orders_uuid');
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->restrictOnDelete();
            $table->foreignId('client_id')->nullable()->constrained('clients')->restrictOnDelete();
            $table->string('order_number', 50)->unique('uq_orders_number');
            $table->string('business_name', 255);
            $table->string('contact_name', 255);
            $table->string('whatsapp', 50);
            $table->text('google_review_url');
            $table->string('package_name', 50);
            $table->integer('point_count')->default(1);
            $table->text('shipping_address');
            $table->string('status', 32)->default('pending'); // pending, processing, shipped, completed, cancelled
            $table->decimal('total_amount', 19, 4)->default(0.0000);
            $table->string('currency', 3)->default('IDR');

            // Standard DB-20 columns
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['tenant_id', 'status'], 'idx_orders_tenant_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
