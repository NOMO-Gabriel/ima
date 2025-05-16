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
        Schema::create('command_units', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->decimal('amount', 10, 2);
            $table->foreignId('material_id')->constrained('materials')->onDelete('cascade');
            $table->foreignId('command_id')->constrained('commands')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('command_units');
    }
};
