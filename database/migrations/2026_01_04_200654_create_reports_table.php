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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->enum('report_type', ['MONTHLY', 'SEASONAL', 'FINANCIAL', 'PRODUCTION', 'AUDIT', 'OTHER']);
            $table->date('period_from');
            $table->date('period_to');
            $table->string('file_path');
            $table->foreignId('prepared_by')->constrained('co_users')->restrictOnDelete();
            $table->foreignId('approved_by_manager')->nullable()->constrained('co_users')->nullOnDelete();
            $table->date('approval_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
