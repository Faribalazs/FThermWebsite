<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ponude', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worker_id')->constrained('users')->onDelete('cascade');
            $table->enum('client_type', ['fizicko_lice', 'pravno_lice'])->default('fizicko_lice');
            $table->string('client_name')->nullable();
            $table->string('client_address')->nullable();
            $table->string('company_name')->nullable();
            $table->string('pib')->nullable();
            $table->string('maticni_broj')->nullable();
            $table->string('company_address')->nullable();
            $table->string('client_phone')->nullable();
            $table->string('client_email')->nullable();
            $table->string('location');
            $table->decimal('km_to_destination', 10, 2)->nullable();
            $table->decimal('hourly_rate', 10, 2)->nullable();
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->string('status')->default('draft');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('ponuda_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ponuda_id')->constrained('ponude')->onDelete('cascade');
            $table->string('title');
            $table->decimal('hours_spent', 8, 2)->nullable();
            $table->decimal('service_price', 10, 2)->nullable();
            $table->timestamps();
        });

        Schema::create('ponuda_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained('ponuda_sections')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('internal_products')->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('price_at_time', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ponuda_items');
        Schema::dropIfExists('ponuda_sections');
        Schema::dropIfExists('ponude');
    }
};
