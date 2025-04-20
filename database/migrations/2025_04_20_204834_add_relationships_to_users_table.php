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
        Schema::table('users', function (Blueprint $table) {
            // Ajout des clés étrangères pour les relations académiques
            $table->unsignedBigInteger('academy_id')->nullable()->after('city_id');
            $table->unsignedBigInteger('department_id')->nullable()->after('academy_id');
            $table->unsignedBigInteger('center_id')->nullable()->after('department_id');
            
            // Contraintes de clé étrangère
            $table->foreign('academy_id')->references('id')->on('academies')->onDelete('set null');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');
            $table->foreign('center_id')->references('id')->on('centers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Suppression des contraintes de clé étrangère
            $table->dropForeign(['academy_id']);
            $table->dropForeign(['department_id']);
            $table->dropForeign(['center_id']);
            
            // Suppression des colonnes
            $table->dropColumn(['academy_id', 'department_id', 'center_id']);
        });
    }
};