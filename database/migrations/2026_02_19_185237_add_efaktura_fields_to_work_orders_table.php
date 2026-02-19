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
            $table->string('efaktura_status')->nullable()->after('has_invoice');
            $table->longText('efaktura_response')->nullable()->after('efaktura_status');
            $table->timestamp('efaktura_sent_at')->nullable()->after('efaktura_response');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->dropColumn(['efaktura_status', 'efaktura_response', 'efaktura_sent_at']);
        });
    }
};
