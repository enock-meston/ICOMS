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
        Schema::create('rice__deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('season_id')->constrained('seasons')->cascadeOnUpdate()->restrictOnDelete();
            $table->date('Delivery_Date')->nullable();
            $table->string('Quantity_KG')->nullable();
            $table->string('Quality_Grade')->nullable();
            $table->string('Unit_Price')->nullable();
            $table->string('Gross_Value')->nullable();
            $table->string('Loan_Deduction')->nullable();
            $table->string('Other_Deductions')->nullable();
            $table->string('Net_Payable')->nullable();
            $table->foreignId('Created_By')->constrained('co_users')->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rice__deliveries');
    }
};
