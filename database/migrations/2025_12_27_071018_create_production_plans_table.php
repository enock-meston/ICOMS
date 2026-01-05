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
        Schema::create('production_plans', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('group_id')->constrained('groups')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('season_id')->constrained('seasons')->cascadeOnUpdate()->restrictOnDelete();
            $table->decimal('planned_area_ha', 10, 2)->nullable();
            $table->decimal('planned_yield_tons', 10, 2)->nullable();
            $table->decimal('planned_inputs_cost', 12, 2)->nullable();
            $table->enum('status', ['DRAFT', 'SUBMITTED', 'APPROVED', 'REJECTED'])->default('DRAFT');
            $table->foreignId('created_by')->constrained('co_users')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('approved_by_manager')->nullable()->constrained('co_users')->nullOnDelete();
            $table->timestamp('approval_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_plans');
    }
};
