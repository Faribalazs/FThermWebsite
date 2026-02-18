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
        // First, create a default warehouse if it doesn't exist
        $warehouse = DB::table('warehouses')->where('name', 'Glavno Skladište')->first();
        if (!$warehouse) {
            $warehouseId = DB::table('warehouses')->insertGetId([
                'name' => 'Glavno Skladište',
                'description' => 'Glavno skladište za materijale',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $warehouseId = $warehouse->id;
        }

        // Add warehouse_id column if it doesn't exist
        if (!Schema::hasColumn('inventories', 'warehouse_id')) {
            Schema::table('inventories', function (Blueprint $table) {
                $table->unsignedBigInteger('warehouse_id')->nullable()->after('internal_product_id');
            });
        }

        // Update existing inventories to use the default warehouse
        DB::table('inventories')->whereNull('warehouse_id')->update(['warehouse_id' => $warehouseId]);

        // Now add foreign key and unique constraint
        try {
            Schema::table('inventories', function (Blueprint $table) {
                $table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('cascade');
            });
        } catch (\Exception $e) {
            // Foreign key already exists, ignore
        }
        
        try {
            Schema::table('inventories', function (Blueprint $table) {
                $table->unique(['internal_product_id', 'warehouse_id']);
            });
        } catch (\Exception $e) {
            // Unique constraint already exists, ignore
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            if (Schema::hasColumn('inventories', 'warehouse_id')) {
                try {
                    $table->dropUnique(['internal_product_id', 'warehouse_id']);
                } catch (\Exception $e) {
                    // Ignore if doesn't exist
                }
                try {
                    $table->dropForeign(['warehouse_id']);
                } catch (\Exception $e) {
                    // Ignore if doesn't exist
                }
                $table->dropColumn('warehouse_id');
            }
        });
    }
};
