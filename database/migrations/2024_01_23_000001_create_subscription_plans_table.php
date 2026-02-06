<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('currency', 3)->default('USD');
            $table->string('billing_cycle'); // monthly, yearly, lifetime
            $table->json('features'); // JSON array of features
            $table->integer('max_articles')->nullable(); // null for unlimited
            $table->integer('max_media_storage')->nullable(); // in MB, null for unlimited
            $table->boolean('can_access_premium_content')->default(false);
            $table->boolean('can_create_private_content')->default(false);
            $table->boolean('can_moderate_comments')->default(false);
            $table->boolean('can_use_advanced_analytics')->default(false);
            $table->boolean('can_remove_branding')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscription_plans');
    }
};
