<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();

            $table->string('receipt_number');
            $table->decimal('contract', 10, 2)->default(0);
            $table->enum('payment_method', [
                'om',
                'momo',
                'cca bank yde',
                'cca bank dla',
                'united credit',
                'uba',
                ''
            ]);

            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('formation_id')->constrained('formations')->onDelete('cascade');

            $table->foreignId('payment_mode_id')->constrained('payment_modes')->onDelete('cascade');
            $table->foreignId('academy_id')->constrained('academies')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
