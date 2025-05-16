<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Student Profile
            $table->string('establishment')->nullable();

            // Teacher Profile
            $table->decimal('salary', 10, 2)->nullable();
            $table->string('cni')->unique();
            $table->string('matricule')->unique();
            $table->date('birthdate');
            $table->string('birthplace');
            $table->string('profession');
            $table->string('department')->nullable();
            $table->foreignId('academy_id')->nullable()->constrained('academies')->onDelete('cascade');
            $table->foreignId('department_id')->nullable()->constrained('departments')->onDelete('cascade');
            $table->foreignId('center_id')->nullable()->constrained('centers')->onDelete('cascade');

            $table->timestamp('last_login_at')->nullable();
            $table->unsignedBigInteger('validated_by')->nullable();
            $table->timestamp('validated_at')->nullable();
            $table->unsignedBigInteger('finalized_by')->nullable();
            $table->timestamp('finalized_at')->nullable();
            $table->text('rejection_reason')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'establishment',
                'salary',
                'cni',
                'matricule',
                'birthdate',
                'birthplace',
                'profession',
                'department',
                'academy_id',
                'last_login_at',
                'validated_by',
                'validated_at',
                'finalized_by',
                'finalized_at',
                'rejection_reason',
            ]);
        });
    }
};
