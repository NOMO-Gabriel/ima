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
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 10)->unique();
            $table->text('description')->nullable();
            $table->string('region')->nullable();
            $table->string('country')->default('Cameroun');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            // Contraintes de clé étrangère
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });

        // Mise à jour de la table des centres pour remplacer la colonne city (string) par city_id
        Schema::table('centers', function (Blueprint $table) {
            // Supprimer la colonne city
            $table->dropColumn('city');
            
            // Ajouter la colonne city_id
            $table->unsignedBigInteger('city_id')->after('academy_id');
            
            // Contrainte de clé étrangère
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
        });

        // Mise à jour de la table users pour remplacer la colonne city (string) par city_id
        Schema::table('users', function (Blueprint $table) {
            // Supprimer la colonne city
            $table->dropColumn('city');
            
            // Ajouter la colonne city_id
            $table->unsignedBigInteger('city_id')->nullable()->after('profile_photo_path');
            
            // Contrainte de clé étrangère
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restaurer la colonne city dans la table users
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['city_id']);
            $table->dropColumn('city_id');
            $table->string('city')->nullable()->after('profile_photo_path');
        });

        // Restaurer la colonne city dans la table centers
        Schema::table('centers', function (Blueprint $table) {
            $table->dropForeign(['city_id']);
            $table->dropColumn('city_id');
            $table->string('city')->after('academy_id');
        });

        Schema::dropIfExists('cities');
    }
};