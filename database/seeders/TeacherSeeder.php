<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Teacher;
use App\Models\Academy;
use App\Models\Department;
use App\Models\Center;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('👨‍🏫 Création des enseignants de test...');

        // S'assurer que le rôle 'enseignant' existe
        $teacherRole = Role::firstOrCreate(['name' => 'enseignant', 'guard_name' => 'web']);

        // Récupérer quelques académies, départements et centres existants
        $academies = Academy::pluck('id', 'name')->toArray();
        $departments = Department::pluck('id', 'name')->toArray();
        $centers = Center::pluck('id', 'name')->toArray();

        $teachers = [
            [
                'first_name' => 'Dr. Charles',
                'last_name' => 'NDONGO',
                'email' => 'charles.ndongo@teacher.test',
                'phone_number' => '+237698222001',
                'city' => 'YAOUNDÉ',
                'status' => User::STATUS_ACTIVE,
                'matricule' => 'T2024001',
                'salary' => 450000,
                'cni' => '123456789YDE',
                'birthdate' => '1985-03-15',
                'birthplace' => 'Yaoundé',
                'profession' => 'Professeur de Mathématiques',
                'department' => 'Sciences Exactes',
                'academy_id' => $academies['Académie Francophone Scientifique'] ?? null,
                'department_id' => $departments['MATHÉMATIQUES'] ?? null,
                'center_id' => array_values($centers)[0] ?? null,
            ],
            [
                'first_name' => 'Mme. Sylvie',
                'last_name' => 'KOM',
                'email' => 'sylvie.kom@teacher.test',
                'phone_number' => '+237698222002',
                'city' => 'DOUALA',
                'status' => User::STATUS_ACTIVE,
                'matricule' => 'T2024002',
                'salary' => 400000,
                'cni' => '987654321DLA',
                'birthdate' => '1990-07-22',
                'birthplace' => 'Douala',
                'profession' => 'Professeure de Physique',
                'department' => 'Sciences Physiques',
                'academy_id' => $academies['Académie Francophone Scientifique'] ?? null,
                'department_id' => $departments['PHYSIQUE'] ?? null,
                'center_id' => array_values($centers)[1] ?? null,
            ],
            [
                'first_name' => 'M. Pierre',
                'last_name' => 'FOTSO',
                'email' => 'pierre.fotso@teacher.test',
                'phone_number' => null,
                'city' => 'BAFOUSSAM',
                'status' => User::STATUS_PENDING_VALIDATION,
                'matricule' => null,
                'salary' => null,
                'cni' => null,
                'birthdate' => null,
                'birthplace' => null,
                'profession' => 'Professeur d\'Anglais',
                'department' => 'Langues',
                'academy_id' => null,
                'department_id' => $departments['ANGLAIS'] ?? null,
                'center_id' => null,
            ],
            [
                'first_name' => 'Dr. Aminatou',
                'last_name' => 'HASSAN',
                'email' => 'aminatou.hassan@teacher.test',
                'phone_number' => '+237698222004',
                'city' => 'GAROUA',
                'status' => User::STATUS_SUSPENDED,
                'matricule' => 'T2024004',
                'salary' => 380000,
                'cni' => '456789123GRA',
                'birthdate' => '1987-12-10',
                'birthplace' => 'Garoua',
                'profession' => 'Professeure de Biologie',
                'department' => 'Sciences Naturelles',
                'academy_id' => $academies['Académie Anglophone Scientifique'] ?? null,
                'department_id' => $departments['BIOLOGIE'] ?? null,
                'center_id' => array_values($centers)[2] ?? null,
            ],
            [
                'first_name' => 'M. Emmanuel',
                'last_name' => 'BIYA',
                'email' => 'emmanuel.biya@teacher.test',
                'phone_number' => '+237698222005',
                'city' => null,
                'status' => User::STATUS_ARCHIVED,
                'matricule' => 'T2023999',
                'salary' => 320000,
                'cni' => null,
                'birthdate' => '1975-05-30',
                'birthplace' => 'Bertoua',
                'profession' => 'Professeur d\'Informatique',
                'department' => null,
                'academy_id' => null,
                'department_id' => null,
                'center_id' => null,
            ],
        ];

        foreach ($teachers as $index => $teacherData) {
            // Créer l'utilisateur
            $user = User::create([
                'first_name' => $teacherData['first_name'],
                'last_name' => $teacherData['last_name'],
                'email' => $teacherData['email'],
                'password' => Hash::make('password123'),
                'phone_number' => $teacherData['phone_number'],
                // 'city' => $teacherData['city'],
                'address' => 'cradat',
                'account_type' => 'teacher',
                
               
            ]);

            // Créer le profil enseignant
            $user->teacherProfile()->create([
                'matricule' => $teacherData['matricule'],
                'salary' => $teacherData['salary'],
                'cni' => $teacherData['cni'],
                'birthdate' => $teacherData['birthdate'],
                'birthplace' => $teacherData['birthplace'],
                'profession' => $teacherData['profession'],
                'department' => $teacherData['department'],
                'academy_id' => $teacherData['academy_id'],
                'department_id' => $teacherData['department_id'],
                // 'center_id' => $teacherData['center_id'],
            ]);

            // Assigner le rôle enseignant
            $user->assignRole($teacherRole);

            $this->command->info("✓ Enseignant créé: {$teacherData['first_name']} {$teacherData['last_name']} ({$teacherData['status']})");
        }

        $this->command->info('✅ 5 enseignants de test créés avec succès!');
        $this->command->info('🔑 Mot de passe par défaut: password123');
    }
}