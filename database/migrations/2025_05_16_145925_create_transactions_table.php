<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->enum('direction', ['IN', 'OUT']);
            $table->foreignId('reason_id')->constrained('transaction_reasons')->onDelete('restrict');
            $table->decimal('amount', 10, 2)->default(0);
            $table->text('description')->nullable();

            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('center_id')->nullable()->constrained('centers')->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
