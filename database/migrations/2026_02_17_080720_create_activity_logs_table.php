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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('action_type'); // e.g., 'create', 'update', 'delete', 'replenish'
            $table->string('entity_type'); // e.g., 'product', 'work_order', 'invoice', 'inventory'
            $table->unsignedBigInteger('entity_id')->nullable();
            $table->string('description');
            $table->json('data')->nullable(); // Store old and new values
            $table->timestamps();
            
            $table->index(['user_id', 'created_at']);
            $table->index(['entity_type', 'entity_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
