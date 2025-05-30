<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('👨‍🎓 Création des étudiants de test...');

        // S'assurer que le rôle 'eleve' existe
        $studentRole = Role::firstOrCreate(['name' => 'eleve', 'guard_name' => 'web']);

        $students = [
            [
                'first_name' => 'Jean',
                'last_name' => 'MBOMA',
                'email' => 'jean.mboma@student.test',
                'phone_number' => '+237698111001',
               //
                'status' => User::STATUS_PENDING_VALIDATION,
                'establishment' => 'Lycée Général Leclerc',
                'parent_phone_number' => '+237699111001',
            ],
            [
                'first_name' => 'Marie',
                'last_name' => 'NGUEMA',
                'email' => 'marie.nguema@student.test',
                'phone_number' => '+237698111002',
               //
                'status' => User::STATUS_PENDING_CONTRACT,
                'establishment' => 'Collège Vogt',
                'parent_phone_number' => '+237699111002',
            ],
            [
                'first_name' => 'Paul',
                'last_name' => 'TCHOUMI',
                'email' => 'paul.tchoumi@student.test',
                'phone_number' => '+237698111003',
                //
                'status' => User::STATUS_ACTIVE,
                'establishment' => 'Lycée Technique de Bafoussam',
                'parent_phone_number' => '+237699111003',
            ],
            [
                'first_name' => 'Fatima',
                'last_name' => 'BELLO',
                'email' => 'fatima.bello@student.test',
                'phone_number' => null,
                //
                'status' => User::STATUS_SUSPENDED,
                'establishment' => 'Lycée de Garoua',
                'parent_phone_number' => '+237699111004',
            ],
            [
                'first_name' => 'Serge',
                'last_name' => 'MVONDO',
                'email' => 'serge.mvondo@student.test',
                'phone_number' => '+237698111005',
             //
                'status' => User::STATUS_REJECTED,
                'establishment' => null,
                'parent_phone_number' => null,
            ],
        ];

        foreach ($students as $index => $studentData) {
            // Créer l'utilisateur
            $user = User::create([
                'first_name' => $studentData['first_name'],
                'last_name' => $studentData['last_name'],
                'email' => $studentData['email'],
                'password' => Hash::make('password123'),
                'phone_number' => $studentData['phone_number'],
                //
                'address' => 'cradat',
                'account_type' => 'student',
                'email_verified_at' => now(),
                
            ]);

            // Créer le profil étudiant
            $user->student()->create([
                'establishment' => $studentData['establishment'],
                'parent_phone_number' => $studentData['parent_phone_number'],
            
            ]);

            // Assigner le rôle élève
            $user->assignRole($studentRole);

            $this->command->info("✓ Étudiant créé: {$studentData['first_name']} {$studentData['last_name']} ({$studentData['status']})");
        }

        $this->command->info('✅ 5 étudiants de test créés avec succès!');
        $this->command->info('🔑 Mot de passe par défaut: password123');
    }
}