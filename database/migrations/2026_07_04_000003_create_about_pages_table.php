<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('about_pages', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique()->default('main');
            $table->json('eyebrow');
            $table->json('title');
            $table->json('intro');
            $table->json('body');
            $table->json('secondary_title');
            $table->json('secondary_body');
            $table->json('values_title');
            $table->json('values');
            $table->json('stats');
            $table->string('hero_image')->nullable();
            $table->json('hero_image_alt')->nullable();
            $table->string('secondary_image')->nullable();
            $table->json('secondary_image_alt')->nullable();
            $table->json('seo_title')->nullable();
            $table->json('seo_description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('about_pages');
    }
};
