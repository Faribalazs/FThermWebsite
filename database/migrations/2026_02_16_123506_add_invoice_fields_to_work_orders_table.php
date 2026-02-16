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
        Schema::table('work_orders', function (Blueprint $table) {
            $table->string('invoice_type')->nullable(); // fizicko_lice or pravno_lice
            $table->string('invoice_number')->nullable();
            $table->string('invoice_company_name')->nullable();
            $table->string('invoice_pib')->nullable();
            $table->string('invoice_address')->nullable();
            $table->string('invoice_email')->nullable();
            $table->string('invoice_phone')->nullable();
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->boolean('has_invoice')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->dropColumn(['invoice_type', 'invoice_number', 'invoice_company_name', 'invoice_pib', 'invoice_address', 'invoice_email', 'invoice_phone', 'total_amount', 'has_invoice']);
        });
    }
};
