<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->string('location')->nullable()->change();
        });

        Schema::table('ponude', function (Blueprint $table) {
            $table->string('location')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->string('location')->nullable(false)->change();
        });

        Schema::table('ponude', function (Blueprint $table) {
            $table->string('location')->nullable(false)->change();
        });
    }
};
