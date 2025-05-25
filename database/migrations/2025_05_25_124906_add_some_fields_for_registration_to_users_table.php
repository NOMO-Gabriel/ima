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
            // Nouveaux champs pour les élèves
            $table->string('parent_phone_number')->nullable()->after('phone_number');
            // Index pour les recherches
            $table->index(['account_type', 'status']);
            $table->index(['center_id', 'status']);
            $table->index(['city_id', 'account_type', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['center_id']);
            $table->dropIndex(['account_type', 'status']);
            $table->dropIndex(['city_id', 'account_type', 'status']);
            
            $table->dropColumn([
                'parent_phone_number',
                'center_id'
            ]);
        });
    }
};