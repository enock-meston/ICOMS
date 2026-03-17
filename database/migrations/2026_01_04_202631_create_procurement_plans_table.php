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
        Schema::create('procurement_plans', function (Blueprint $table) {
            $table->id();
            $table->string('fiscal_year');

            $table->foreignId('prepared_by')->constrained('co_users');
            $table->foreignId('approved_by_manager')->nullable()->constrained('co_users');
            $table->foreignId('approved_by_board')->nullable()->constrained('co_users');
            $table->date('approval_date')->nullable();
            $table->enum('status', [
                'DRAFT',
                'UNDER_REVIEW',
                'APPROVED',
                'ARCHIVED'
            ])->default('DRAFT');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procurement_plans');
    }
};
