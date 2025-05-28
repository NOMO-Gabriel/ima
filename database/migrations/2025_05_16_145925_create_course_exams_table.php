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
        Schema::create('course_mock_exams', function (Blueprint $table) {
            $table->id();

            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('mock_exam_id')->constrained('mock_exams')->onDelete('cascade');
            $table->float('max_note', 5, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_mock_exams');
    }
};