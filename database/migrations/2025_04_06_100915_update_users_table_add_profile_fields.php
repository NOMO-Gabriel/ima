<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Renommer name en first_name
            $table->renameColumn('name', 'first_name');
            
            // Ajouter les nouveaux champs
            $table->string('last_name')->after('first_name')->nullable();
            $table->string('phone_number')->nullable()->unique();
            $table->string('profile_photo_path')->nullable();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->enum('status', [
                'pending_validation',
                'pending_finalization',
                'active',
                'suspended',
                'rejected',
                'archived'
            ])->default('pending_validation');
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
            $table->renameColumn('first_name', 'name');
            $table->dropColumn([
                'last_name', 'phone_number', 'profile_photo_path',
                'city', 'address', 'status', 'last_login_at',
                'validated_by', 'validated_at', 'finalized_by',
                'finalized_at', 'rejection_reason'
            ]);
        });
    }
};