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
        Schema::table('work_order_items', function (Blueprint $table) {
            $table->dropForeign(['material_id']);
            $table->renameColumn('material_id', 'product_id');
            $table->foreign('product_id')->references('id')->on('internal_products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_order_items', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->renameColumn('product_id', 'material_id');
            $table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade');
        });
    }
};
