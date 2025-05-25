<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🧪 Création de la responsable financière de test...');

        // Vérifier si l'utilisateur existe déjà
        $existingUser = User::where('email', 'resp.financier@test.com')->first();
        
        if ($existingUser) {
            $this->command->warn('⚠️  Responsable financier existe déjà: resp.financier@test.com');
            return;
        }

        $user = User::create([
            'first_name' => 'Responsable',
            'last_name' => 'Financier',
            'email' => 'resp.financier@test.com',
            'password' => Hash::make('password123'),
            'phone_number' => '+237111222333',
            'city_id' => 1, // Yaoundé
            'account_type' => 'resp-financier',
            'status' => 'active',
            'validated_at' => now(),
            'finalized_at' => now(),
        ]);

        $user->myAssignRole('resp-financier');
        
        $this->command->info('✅ Responsable financier créé avec succès!');
        $this->command->info('📧 Email: resp.financier@test.com');
        $this->command->info('🔑 Mot de passe: password123');
    }
}