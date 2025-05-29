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
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->string('address');
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->boolean('is_active')->default(true);
            $table->json('staff_ids')->nullable()->default(null);

            $table->foreignId('city_id')->nullable()->constrained('cities')->onDelete('set null');
            $table->foreignId('director_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('logistics_director_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('finance_director_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('academy_id')->nullable()->constrained('academies')->onDelete('set null');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('centers');
    }
};
