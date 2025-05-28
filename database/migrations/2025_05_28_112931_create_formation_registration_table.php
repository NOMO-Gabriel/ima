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
        Schema::create('formation_registration', function (Blueprint $table) {
            $table->id();

            $table->foreignId('registration_id')->constrained('registrations')->onDelete('cascade');
            $table->foreignId('formation_id')->constrained('formations')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formation_registration');
    }
};
