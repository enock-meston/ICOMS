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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->text('message');
            $table->enum('channel', ['SMS', 'APP', 'EMAIL']);
            $table->string('related_entity')->nullable();
            $table->unsignedBigInteger('related_id')->nullable();
            $table->timestamp('sent_date')->nullable();
            $table->enum('read_status', ['UNREAD', 'READ'])->default('UNREAD');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
