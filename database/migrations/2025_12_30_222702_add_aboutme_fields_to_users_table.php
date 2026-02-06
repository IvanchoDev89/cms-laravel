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
        Schema::table('users', function (Blueprint $table) {
            $table->text('bio')->nullable()->after('email');
            $table->string('title')->nullable()->after('bio');
            $table->string('location')->nullable()->after('title');
            $table->string('website')->nullable()->after('location');
            $table->string('phone')->nullable()->after('website');
            $table->json('skills')->nullable()->after('phone');
            $table->json('experience')->nullable()->after('skills');
            $table->json('education')->nullable()->after('experience');
            $table->json('social_links')->nullable()->after('education');
            $table->string('profile_image_path')->nullable()->after('social_links');
            $table->boolean('show_profile_publicly')->default(false)->after('profile_image_path');
            $table->boolean('show_email_publicly')->default(false)->after('show_profile_publicly');
            $table->boolean('show_phone_publicly')->default(false)->after('show_email_publicly');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'bio',
                'title',
                'location',
                'website',
                'phone',
                'skills',
                'experience',
                'education',
                'social_links',
                'profile_image_path',
                'show_profile_publicly',
                'show_email_publicly',
                'show_phone_publicly',
            ]);
        });
    }
};
