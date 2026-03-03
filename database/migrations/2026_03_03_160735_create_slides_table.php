<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('slides', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->json('title')->nullable();
            $table->json('description')->nullable();
            $table->json('button_text')->nullable();
            $table->string('button_link')->nullable();
            $table->enum('text_position_x', ['left', 'center', 'right'])->default('left');
            $table->enum('text_position_y', ['top', 'center', 'bottom'])->default('center');
            $table->integer('order')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('slides');
    }
};
