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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string("member_code")->unique();
            $table->string("names");
            $table->string("phone");
            $table->string("gender");
            $table->foreignId('group_id')->constrained('groups')->cascadeOnUpdate()->restrictOnDelete();
            $table->string("national_ID");
            $table->date("joinDate");
            $table->string("Shares");
            $table->enum("status",['active','suspended','exited']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
