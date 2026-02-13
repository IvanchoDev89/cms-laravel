<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('plan_id')->constrained('subscription_plans')->onDelete('cascade');
            $table->string('status'); // active, cancelled, expired, suspended
            $table->decimal('amount_paid', 10, 2);
            $table->string('currency', 3)->default('USD');
            $table->string('payment_method'); // paypal, bitcoin, stripe
            $table->string('transaction_id')->nullable();
            $table->timestamp('starts_at');
            $table->timestamp('ends_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('trial_ends_at')->nullable();
            $table->json('metadata')->nullable(); // Additional payment data
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['status', 'ends_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
