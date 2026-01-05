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
        Schema::create('tenders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('procurement_items');

            $table->string('tender_ref_no')->unique();
            $table->string('title');

            $table->enum('procurement_method', [
                'OPEN_TENDER',
                'RFQ',
                'DIRECT',
                'OTHER'
            ]);

            $table->date('publish_date');
            $table->date('closing_date');

            $table->enum('status', [
                'PLANNED',
                'PUBLISHED',
                'UNDER_EVALUATION',
                'AWARDED',
                'CANCELLED',
                'FAILED'
            ])->default('PLANNED');

            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('approved_by_manager')->nullable()->constrained('users');

            $table->string('notice_file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenders');
    }
};
