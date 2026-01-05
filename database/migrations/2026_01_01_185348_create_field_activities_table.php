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
        Schema::create('field_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->constrained('production_plans')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('activity_type');
            $table->date('planned_date');
            $table->date('actual_date')->nullable();
            $table->foreignId('officer_user_id')->constrained('co_users')->cascadeOnUpdate()->restrictOnDelete();
            $table->enum('status', ['PENDING','DONE','DELAYED','CANCELLED'])->default('PENDING');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('field_activities');
    }
};
