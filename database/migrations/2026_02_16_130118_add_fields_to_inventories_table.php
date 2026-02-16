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
        Schema::table('inventories', function (Blueprint $table) {
            $table->foreignId('internal_product_id')->after('id')->constrained('internal_products')->onDelete('cascade');
            $table->integer('quantity')->default(0)->after('internal_product_id');
            $table->foreignId('updated_by')->nullable()->after('quantity')->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->dropForeign(['internal_product_id']);
            $table->dropForeign(['updated_by']);
            $table->dropColumn(['internal_product_id', 'quantity', 'updated_by']);
        });
    }
};
