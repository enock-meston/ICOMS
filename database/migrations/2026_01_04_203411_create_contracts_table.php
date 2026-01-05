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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tender_id')->constrained();
    $table->foreignId('supplier_id')->constrained();

    $table->string('contract_no')->unique();
    $table->text('description');
    $table->decimal('contract_amount', 15, 2);

    $table->date('start_date');
    $table->date('end_date');

    $table->foreignId('signed_by_manager')->constrained('co_users');
    $table->timestamp('signed_at');

    $table->enum('status', ['ACTIVE', 'COMPLETED', 'TERMINATED'])->default('ACTIVE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
