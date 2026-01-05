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
        Schema::create('supplier_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained();
            $table->foreignId('delivery_id')->constrained();
            $table->foreignId('supplier_id')->constrained();

            $table->decimal('amount', 15, 2);
            $table->date('payment_date');

            $table->enum('channel', ['BANK', 'CASH', 'MOMO', 'OTHER']);

            $table->foreignId('approved_by_manager')->nullable()->constrained('co_users');

            $table->enum('status', [
                'PENDING',
                'APPROVED',
                'PAID',
                'CANCELLED'
            ])->default('PENDING');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_payments');
    }
};
