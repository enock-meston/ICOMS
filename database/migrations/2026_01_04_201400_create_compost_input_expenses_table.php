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
        Schema::create('compost_input_expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('compost_id')->constrained('compost_group_productions')->cascadeOnDelete();
            $table->enum('expense_type', ['Seed_Capital', 'Tools', 'Labor', 'Transport', 'Other']);
            $table->decimal('amount', 12, 2);
            $table->enum('provided_by', ['COOPERATIVE', 'GROUP', 'DONOR']);
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compost_input_expenses');
    }
};
