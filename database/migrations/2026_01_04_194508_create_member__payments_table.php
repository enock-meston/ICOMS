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
        Schema::create('member__payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('delivery_id')->constrained('rice__deliveries')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('amount')->nullable();
            $table->date('payment_Date')->nullable();
            $table->enum('payment',['CASH','MOMO','BANK','OTHER']);
            $table->foreignId('manager_id')->constrained('co_users')->cascadeOnUpdate()->restrictOnDelete();
            $table->enum('status',['PENDING','APPROVED','PAID','CANCELLED']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member__payments');
    }
};
