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
            // Champs pour la validation financière
            $table->unsignedBigInteger('validated_by_financial')->nullable()->after('finalized_at');
            $table->timestamp('financial_validation_date')->nullable()->after('validated_by_financial');
            
            // Champs pour les élèves - concours et contrat
            $table->json('wanted_entrance_exams')->nullable()->after('financial_validation_date');
            $table->json('contract_details')->nullable()->after('wanted_entrance_exams');
            $table->boolean('entrance_exam_assigned')->default(false)->after('contract_details');
            $table->boolean('contract_assigned')->default(false)->after('entrance_exam_assigned');
            
            // Contrainte de clé étrangère pour la validation financière
            $table->foreign('validated_by_financial')->references('id')->on('users')->onDelete('set null');
        });

        // Mettre à jour les statuts existants dans l'enum
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->enum('status', [
                'pending_validation',
                'pending_contract', 
                'active',
                'suspended',
                'rejected',
                'archived'
            ])->default('pending_validation')->after('account_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['validated_by_financial']);
            $table->dropColumn([
                'validated_by_financial',
                'financial_validation_date',
                'wanted_entrance_exams',
                'contract_details',
                'entrance_exam_assigned',
                'contract_assigned'
            ]);
        });

        // Restaurer l'ancien enum status
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->enum('status', [
                'pending_validation',
                'pending_finalization',
                'active',
                'suspended',
                'rejected',
                'archived'
            ])->default('pending_validation')->after('account_type');
        });
    }
};