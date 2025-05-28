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

            // Author
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');

            // Ressource
            $table->string('subject_type'); // Impact entity | ex: "App\Models\User"
            $table->unsignedBigInteger('subject_id'); // Impact entity id

            // Changes
            $table->enum('action', ['created', 'updated', 'deleted', 'validated', 'suspended', 'rejected', 'archived'])->nullable();
            $table->json('changes')->nullable(); // Array of updated fields

            // Free message
            $table->text('description')->nullable();

            // Configuration
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent')->nullable(); // System context dump

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('histories');
    }
};
