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
        Schema::create('tender_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tender_id')->constrained();
            $table->foreignId('committee_id')->constrained('committees');

            $table->date('evaluation_date');
            $table->string('report_file')->nullable();

            $table->foreignId('recommended_supplier_id')->nullable()->constrained('suppliers');
            $table->decimal('recommended_amount', 15, 2)->nullable();

            $table->foreignId('approved_by_manager')->nullable()->constrained('co_users');
            $table->foreignId('approved_by_board')->nullable()->constrained('co_users');

            $table->enum('status', ['DRAFT', 'SUBMITTED', 'APPROVED', 'REJECTED'])
                ->default('DRAFT');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tender_evaluations');
    }
};
