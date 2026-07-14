<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('homepage_trust_sections', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique()->default('main');
            $table->json('eyebrow');
            $table->json('title');
            $table->json('intro');
            $table->json('metrics');
            $table->json('items');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('homepage_trust_sections');
    }
};
