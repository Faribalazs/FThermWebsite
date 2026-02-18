<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Get the first warehouse ID
        $defaultWarehouseId = DB::table('warehouses')->where('is_active', true)->first()?->id;
        
        if ($defaultWarehouseId) {
            // Step 1: Add column as nullable
            Schema::table('work_orders', function (Blueprint $table) {
                $table->unsignedBigInteger('warehouse_id')->nullable()->after('worker_id');
            });
            
            // Step 2: Update existing records
            DB::table('work_orders')->update(['warehouse_id' => $defaultWarehouseId]);
            
            // Step 3: Make it non-nullable and add foreign key
            Schema::table('work_orders', function (Blueprint $table) {
                $table->unsignedBigInteger('warehouse_id')->nullable(false)->change();
                $table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('restrict');
            });
        } else {
            // If no warehouse exists, just add nullable column with foreign key
            Schema::table('work_orders', function (Blueprint $table) {
                $table->foreignId('warehouse_id')->nullable()->after('worker_id')->constrained('warehouses')->onDelete('restrict');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->dropForeign(['warehouse_id']);
            $table->dropColumn('warehouse_id');
        });
    }
};
