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
        Schema::create('compost_usages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('compost_id')
                ->constrained('compost_group_productions')
                ->cascadeOnDelete();

            $table->foreignId('member_id')
                ->constrained('members')
                ->restrictOnDelete();

            $table->decimal('qty_used_kg', 10, 2);
            $table->decimal('price_per_kg', 10, 2);
            $table->decimal('total_amount', 15, 2);

            $table->enum('payment_type', ['CASH', 'LOAN_DEDUCTION']);
            $table->enum('status', ['PENDING', 'PAID'])->default('PENDING');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compost_usages');
    }
};
