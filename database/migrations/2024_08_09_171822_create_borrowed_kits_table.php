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
        Schema::create('borrowed_kits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kit_id');
            $table->unsignedBigInteger('student_id')->nullable();
            $table->integer('quantity_borrowed')->default(1);
            $table->date('borrowed_at');
            $table->date('due_date')->nullable();
            $table->date('returned_at')->nullable();
            $table->enum('status', ['borrowed', 'returned'])->default('borrowed');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowed_kits');
    }
};
