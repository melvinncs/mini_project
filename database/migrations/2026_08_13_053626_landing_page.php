<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('LandingPage', function (Blueprint $table) {
            $table->id();

            // Hero
            $table->string('hero_badge_1')->default('#1 Drama Korea');
            $table->string('hero_badge_2')->default('⭐ 4.8/5 Rating');
            $table->string('hero_badge_3')->default('🔥 500+ Drama');
            $table->string('hero_title_line1')->default('Portal');
            $table->string('hero_title_highlight')->default('Drama Korea');
            $table->string('hero_title_line2')->default('Terlengkap & Terupdate');
            $table->text('hero_description')->nullable();
            $table->string('hero_btn_primary_text')->default('Jelajahi Drama →');
            $table->string('hero_btn_secondary_text')->default('Baca Artikel');
            $table->string('hero_image')->nullable();

            // Section Drama
            $table->string('drama_tag')->default('Trending Now');
            $table->string('drama_title')->default('Drama Terbaru');
            $table->text('drama_desc')->nullable();

            // Section Artikel
            $table->string('artikel_tag')->default('Terbaru');
            $table->string('artikel_title')->default('Artikel Drama Korea');
            $table->text('artikel_desc')->nullable();

            // Footer
            $table->string('footer_brand_short')->default('KD');
            $table->string('footer_brand_name')->default('K-DramaHub');
            $table->text('footer_description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('LandingPage');
    }
};