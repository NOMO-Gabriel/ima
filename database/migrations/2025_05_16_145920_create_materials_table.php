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
            $table->integer('stock')->default(0);
            $table->integer('price')->default(0);
            $table->enum('type', ['booklet', 'mock_exam', 'sheet', 'other'])->default('other');

            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // For location : national, city, center

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};