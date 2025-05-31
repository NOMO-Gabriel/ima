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
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->morphs('movable'); // booklet_id, booklet_type OU sheet_id, sheet_type
            $table->enum('type', ['received', 'distributed_to_center', 'correction_add', 'correction_remove']);
            $table->integer('quantity');
            $table->foreignId('center_id')->nullable()->constrained('centers')->onDelete('set null'); // Pour 'distributed_to_center'
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Qui a fait l'action
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
