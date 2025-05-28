<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('formation_books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
            $table->foreignId('formation_id')->constrained('formations')->onDelete('cascade');
            $table->timestamps();

            // Contrainte d'unicité pour éviter les doublons
            $table->unique(['book_id', 'formation_id']);

            // Index pour optimiser les performances
            $table->index('book_id');
            $table->index('formation_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('formation_books');
    }
};
