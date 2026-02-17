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
            $table->string('client_type')->default('fizicko_lice')->after('client_name'); // fizicko_lice or pravno_lice
            $table->string('company_name')->nullable()->after('client_type');
            $table->string('pib')->nullable()->after('company_name');
            $table->string('contact_person')->nullable()->after('pib');
            $table->string('client_phone')->nullable()->after('contact_person');
            $table->string('client_email')->nullable()->after('client_phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_orders', function (Blueprint $table) {
            $table->dropColumn([
                'client_type',
                'company_name',
                'pib',
                'contact_person',
                'client_phone',
                'client_email',
            ]);
        });
    }
};
