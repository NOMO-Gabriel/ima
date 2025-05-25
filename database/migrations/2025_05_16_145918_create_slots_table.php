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
        Schema::create('slots', function (Blueprint $table) {
            $table->id();

            $table->time('start_time');
            $table->time('end_time');
            $table->string('week_day');

            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            $table->foreignId('formation_id')->constrained('formations')->onDelete('cascade');
            $table->foreignId('timetable_id')->nullable()->constrained('timetables')->onDelete('set null');
            $table->foreignId('teacher_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('course_id')->nullable()->constrained('courses')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('slots', function (Blueprint $table) {
            $table->dropForeign(['timetable_id']);
            $table->dropForeign(['room_id']);
            $table->dropForeign(['teacher_id']);
            $table->dropForeign(['course_id']);
            $table->dropForeign(['formation_id']);
        });
        Schema::dropIfExists('slots');
    }
};