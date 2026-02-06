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
        Schema::create('content_access', function (Blueprint $table) {
            $table->id();
            $table->string('content_type');
            $table->unsignedBigInteger('content_id');
            $table->enum('access_level', ['free', 'premium', 'exclusive'])->default('free');
            $table->json('required_plans')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['content_type', 'content_id']);
            $table->index('access_level');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_access');
    }
};
