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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('assigned_to')->constrained('co_users')->restrictOnDelete();
            $table->foreignId('created_by')->constrained('co_users')->restrictOnDelete();
            $table->foreignId('related_decision_id')->nullable()->constrained('decisions')->nullOnDelete();
            $table->foreignId('related_plan_id')->nullable()->constrained('production_plans')->nullOnDelete();
            $table->enum('priority', ['HIGH', 'MEDIUM', 'LOW']);
            $table->date('start_date')->nullable();
            $table->date('due_date')->nullable();
            $table->enum('status', ['OPEN', 'IN_PROGRESS', 'COMPLETED', 'CANCELLED']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
