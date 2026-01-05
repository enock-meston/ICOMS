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
        Schema::create('compost_group_productions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained()->cascadeOnDelete();
            $table->foreignId('season_id')->constrained()->cascadeOnDelete();
            $table->string('material_type');
            $table->date('production_start');
            $table->date('production_end')->nullable();
            $table->decimal('qty_produced_kg', 10, 2);
            $table->decimal('estimated_value', 12, 2);
            $table->enum('status', ['IN_PROGRESS', 'READY', 'SOLD', 'USED']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compost_group_productions');
    }
};
