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
        Schema::create('input__allocations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('season_id')->constrained('seasons')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('Type_')->nullable();
            $table->string('Quantity')->nullable();
            $table->string('Unit_Cost')->nullable();
            $table->string('Total_Value')->nullable();
            $table->string('Issue_Date');
            $table->foreignId('approved_by_manager')->nullable()->constrained('co_users')->nullOnDelete();
            $table->date('Approval_Date');
            $table->enum('Status',['PENDING','APPROVED','REJECTED','CLOSED']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('input__allocations');
    }
};
