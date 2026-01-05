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
        Schema::create('procurement_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('Procu_plan_id')->constrained('procurement_plans');
            $table->foreignId('department_id')->constrained('departments');

            $table->string('description');
            $table->integer('quantity');
            $table->string('unit_of_measure');

            $table->decimal('estimated_unit_cost', 15, 2);
            $table->decimal('estimated_total_cost', 15, 2);

            $table->enum('procurement_method', [
                'OPEN_TENDER',
                'RFQ',
                'DIRECT',
                'OTHER'
            ]);

            $table->enum('priority', ['HIGH', 'MEDIUM', 'LOW'])->default('MEDIUM');
            $table->date('planned_tender_date')->nullable();

            $table->enum('status', [
                'PLANNED',
                'TENDERED',
                'CANCELLED',
                'COMPLETED'
            ])->default('PLANNED');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procurement_items');
    }
};
