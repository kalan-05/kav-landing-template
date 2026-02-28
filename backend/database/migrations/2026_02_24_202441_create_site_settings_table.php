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
        Schema::create('site_settings', function (Blueprint $table): void {
            $table->id();
            $table->string('site_name')->default('KAV Landing Template');
            $table->string('phone_1')->nullable();
            $table->string('phone_2')->nullable();
            $table->string('email')->nullable();
            $table->text('address_main')->nullable();
            $table->string('worktime_main')->nullable();
            $table->json('social')->nullable();
            $table->string('logo')->nullable();
            $table->string('hero_image')->nullable();
            $table->string('team_image')->nullable();
            $table->string('developer_logo')->nullable();
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->text('seo_keywords')->nullable();
            $table->string('og_image')->nullable();
            $table->decimal('map_lat', 10, 7)->nullable();
            $table->decimal('map_lng', 10, 7)->nullable();
            $table->unsignedTinyInteger('map_zoom')->default(14);
            $table->string('theme_body_bg')->nullable();
            $table->string('theme_nav_bg')->nullable();
            $table->string('theme_accent_bg')->nullable();
            $table->string('theme_text_body')->nullable();
            $table->string('theme_text_secondary')->nullable();
            $table->string('theme_text_accent')->nullable();
            $table->string('theme_border_color')->nullable();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};

