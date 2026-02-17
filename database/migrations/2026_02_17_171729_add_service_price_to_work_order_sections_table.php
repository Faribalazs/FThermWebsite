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
        Schema::table('work_order_sections', function (Blueprint $table) {
            $table->decimal('service_price', 10, 2)->nullable()->after('hours_spent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_order_sections', function (Blueprint $table) {
            $table->dropColumn('service_price');
        });
    }
};
