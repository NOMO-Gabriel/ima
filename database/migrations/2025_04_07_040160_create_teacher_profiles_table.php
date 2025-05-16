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
        Schema::create('teacher_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('salary', 10, 2)->nullable();
            $table->string('cni')->unique();
            $table->string('matricule')->unique();
            $table->date('birthdate');
            $table->string('birthplace');
            $table->string('profession');
            $table->string('department')->nullable();
            $table->foreignId('academy_id')->constrained('academies')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
