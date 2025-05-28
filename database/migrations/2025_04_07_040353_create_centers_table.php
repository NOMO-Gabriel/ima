<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('centers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedInteger('nb_students')->default(0);

            // Responsables du centre (tous nullables)
            $table->unsignedBigInteger('director_id')->nullable();
            $table->unsignedBigInteger('head_id')->nullable();
            $table->unsignedBigInteger('logistics_director_id')->nullable();
            $table->unsignedBigInteger('finance_director_id')->nullable();
            $table->unsignedBigInteger('academic_manager_id')->nullable();

            // Liste des personnels (nullable, type JSON avec des IDs de users)
            $table->json('staff_ids')->nullable()->default(null);

            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            // Clés étrangères
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('set null');
            $table->foreign('director_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('head_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('logistics_director_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('finance_director_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('academic_manager_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('centers');
    }
};
