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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->decimal('amount', 10, 2);
            $table->enum('transaction_type', ['IN', 'OUT']);
            $table->enum('transaction_reason', ['TEACHER_PAYMENT', 'STUDENT_REGISTRATION', 'BOOK_SELL', 'CLASS_LOCATION', 'STAFF_MANAGEMENT', 'SALARY', 'OTHER']);
            $table->foreignId('author_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};