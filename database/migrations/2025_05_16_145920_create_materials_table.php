<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('unit', ['pcs', 'kg', 'g', 'm', 'cm', 'mm', 'l', 'ml', 'm2', 'm3', 'set', 'box', 'pack'])->default('pcs');
            $table->integer('quantity')->default(0);

            $table->foreignId('center_id')->constrained('centers')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};