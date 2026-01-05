<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing permissions that don't have guard_name set
        DB::table('permissions')
            ->whereNull('guard_name')
            ->orWhere('guard_name', '')
            ->update(['guard_name' => 'web']);

        // Update existing roles that don't have guard_name set
        DB::table('roles')
            ->whereNull('guard_name')
            ->orWhere('guard_name', '')
            ->update(['guard_name' => 'web']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration is not reversible as we don't know the original state
    }
};
