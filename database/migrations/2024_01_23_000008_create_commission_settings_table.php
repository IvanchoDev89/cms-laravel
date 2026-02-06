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
        Schema::create('commission_settings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('rate', 5, 4);
            $table->enum('type', ['percentage', 'fixed'])->default('percentage');
            $table->string('applies_to');
            $table->json('applicable_plans')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('effective_from')->default(now());
            $table->timestamp('effective_until')->nullable();
            $table->timestamps();

            $table->unique('name');
            $table->index('is_active');
            $table->index(['effective_from', 'effective_until']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commission_settings');
    }
};
