<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $timestamp = now();

        DB::table('settings')->insertOrIgnore([
            'key' => 'shop_enabled',
            'value' => 'false',
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);

        // Also disable catalogs that were enabled by the old seeder.
        DB::table('settings')->where('key', 'shop_enabled')->update([
            'value' => 'false',
            'updated_at' => $timestamp,
        ]);
    }

    public function down(): void
    {
        // The previous visibility choice is unknown; rollback must not publish the catalog.
    }
};
