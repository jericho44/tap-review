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
        Schema::create('themes', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique('uq_themes_uuid');
            $table->string('name', 100);
            $table->string('primary_color', 16);
            $table->string('accent_color', 16);
            $table->string('call_to_action', 255);
            $table->string('print_size', 32)->default('A6'); // A6, Round-8cm, Card
            $table->string('preview_image_url', 500)->nullable();
            $table->jsonb('style_config')->default('{}');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('themes');
    }
};
