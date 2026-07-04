<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->string('email')->nullable()->change();
            $table->string('service_type')->nullable()->after('phone');
            $table->string('city')->nullable()->after('service_type');
            $table->string('preferred_contact')->nullable()->after('city');
        });
    }

    public function down(): void
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->dropColumn(['service_type', 'city', 'preferred_contact']);
            $table->string('email')->nullable(false)->change();
        });
    }
};
