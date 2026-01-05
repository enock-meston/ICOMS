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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained();
            $table->date('delivery_date');

            $table->text('delivery_description');
            $table->decimal('quantity_received', 10, 2);
            $table->decimal('value_received', 15, 2);

            $table->foreignId('receiving_committee_id')->constrained('committees');

            $table->string('grn_no')->unique();

            $table->enum('conformity_status', [
                'ACCEPTED',
                'PARTIALLY_ACCEPTED',
                'REJECTED'
            ]);

            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
