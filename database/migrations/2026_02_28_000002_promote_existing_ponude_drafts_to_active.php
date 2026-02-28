<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // All ponude that existed before autosave was introduced were submitted
        // properly — promote them to 'active' so they don't appear as drafts.a
        DB::table('ponude')->where('status', 'draft')->update(['status' => 'active']);
    }

    public function down(): void
    {
        DB::table('ponude')->where('status', 'active')->update(['status' => 'draft']);
    }
};
