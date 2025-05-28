<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('histories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Author
            $table->string('subject_type'); // Impact entity | ex: "App\Models\User"
            $table->unsignedBigInteger('subject_id');

            // Description de l'action
            $table->string('action'); // ex: "created", "updated", "deleted", "validated"

            // Détails (optionnels)
            $table->json('changes')->nullable(); // pour stocker les modifications ou contenu de l'action
            $table->text('description')->nullable(); // Free message

            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('histories');
    }
};
