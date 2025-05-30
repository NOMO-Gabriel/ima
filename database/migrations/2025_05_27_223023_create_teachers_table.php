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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();

            $table->string('matricule')->nullable()->unique();
            $table->decimal('salary', 10, 2)->nullable();
            $table->string('cni')->nullable()->unique();
            $table->date('birthdate')->nullable();
            $table->string('birthplace')->nullable();
            $table->string('profession')->nullable();
            $table->string('department')->nullable();

            $table->foreignId('academy_id')->nullable()->constrained('academies')->onDelete('cascade');
            $table->foreignId('department_id')->nullable()->constrained('departments')->onDelete('cascade');
            $table->foreignId('city_id')->nullable()->constrained('cities')->onDelete('cascade');

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

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
