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
            $table->decimal('hourly_rate', 10, 2)->nullable()->after('total_amount');
        });

        Schema::table('work_order_sections', function (Blueprint $table) {
            $table->decimal('hours_spent', 8, 2)->nullable()->after('title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->dropColumn('hourly_rate');
        });

        Schema::table('work_order_sections', function (Blueprint $table) {
            $table->dropColumn('hours_spent');
        });
    }
};
