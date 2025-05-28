<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mock_exams', function (Blueprint $table) {
            $table->id();

            $table->dateTime('date');
            $table->enum('type', ['QCM', 'REDACTION', 'MIX']);
            $table->integer('duration')->default(0);

            $table->foreignId('formation_id')->constrained('formations')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mock_exams');
    }
};