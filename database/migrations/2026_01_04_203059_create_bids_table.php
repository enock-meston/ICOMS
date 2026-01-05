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
        Schema::create('bids', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tender_id')->constrained();
            $table->foreignId('supplier_id')->constrained();

            $table->decimal('bid_amount', 15, 2);
            $table->decimal('technical_score', 5, 2)->nullable();
            $table->decimal('financial_score', 5, 2)->nullable();
            $table->decimal('overall_score', 5, 2)->nullable();

            $table->enum('evaluation_result', ['RESPONSIVE', 'NON_RESPONSIVE'])->nullable();
            $table->enum('recommendation', ['WINNER', 'NOT_WINNER'])->nullable();

            $table->timestamp('submitted_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bids');
    }
};
