<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\City;
use App\Models\Academy;
use App\Models\Center;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer les entités nécessaires
        $cities = City::pluck('id', 'name')->toArray();
        $academies = Academy::pluck('id', 'name')->toArray();
        $centers = Center::pluck('id', 'name')->toArray();
        $departments = Department::pluck('id', 'name')->toArray();

        $this->command->info('🚀 Création du personnel administratif...');

        // Créer les utilisateurs par niveau hiérarchique
        $this->createNationalStaff($cities, $academies);
        $this->createCityStaff($cities);
        $this->createCenterStaff($centers, $cities);
        $this->createDepartmentHeads($departments, $academies);

        $this->command->info('✅ Personnel administratif créé avec succès!');
        $this->command->info('📧 Email pattern: {role}@ima-icorp.com');
        $this->command->info('🔑 Mot de passe par défaut: password123');
    }

    /**
     * Créer le personnel de niveau national
     */
    private function createNationalStaff($cities, $academies)
    {
        $this->command->info('👑 Création du personnel national...');

        $nationalUsers = [
            [
                'role' => 'pca',
                'first_name' => 'Président',
                'last_name' => 'Conseil Administration',
                'email' => 'pca@ima-icorp.com',
                'phone_number' => '+237698000001',
                'city_id' => $cities['YAOUNDÉ'] ?? null,
            ],
            [
                'role' => 'cn',
                'first_name' => 'Contrôleur',
                'last_name' => 'National',
                'email' => 'controleur@ima-icorp.com',
                'phone_number' => '+237698000002',
                'city_id' => $cities['YAOUNDÉ'] ?? null,
            ],
            [
                'role' => 'dg',
                'first_name' => 'Directeur',
                'last_name' => 'Général',
                'email' => 'dg@ima-icorp.com',
                'phone_number' => '+237698000003',
                'city_id' => $cities['YAOUNDÉ'] ?? null,
            ],
            [
                'role' => 'sg',
                'first_name' => 'Secrétaire',
                'last_name' => 'Général',
                'email' => 'sg@ima-icorp.com',
                'phone_number' => '+237698000004',
                'city_id' => $cities['YAOUNDÉ'] ?? null,
            ],
            [
                'role' => 'da',
                'first_name' => 'Directeur Académique',
                'last_name' => 'Francophone',
                'email' => 'da-francophone@ima-icorp.com',
                'phone_number' => '+237698000005',
                'city_id' => $cities['YAOUNDÉ'] ?? null,
            ],
            [
                'role' => 'da',
                'first_name' => 'Directeur Académique',
                'last_name' => 'Anglophone',
                'email' => 'da-anglophone@ima-icorp.com',
                'phone_number' => '+237698000006',
                'city_id' => $cities['YAOUNDÉ'] ?? null,
            ],
            [
                'role' => 'rl',
                'first_name' => 'Responsable',
                'last_name' => 'Livres National',
                'email' => 'rl-national@ima-icorp.com',
                'phone_number' => '+237698000007',
                'city_id' => $cities['YAOUNDÉ'] ?? null,
            ],
            [
                'role' => 'df-n',
                'first_name' => 'Directrice Financière',
                'last_name' => 'Nationale',
                'email' => 'df-national@ima-icorp.com',
                'phone_number' => '+237698000008',
                'city_id' => $cities['YAOUNDÉ'] ?? null,
            ],
            [
                'role' => 'dl-n',
                'first_name' => 'Directeur Logistique',
                'last_name' => 'National',
                'email' => 'dl-national@ima-icorp.com',
                'phone_number' => '+237698000009',
                'city_id' => $cities['YAOUNDÉ'] ?? null,
            ],
        ];

        foreach ($nationalUsers as $userData) {
            $user = $this->createUser($userData);
            $user->assignRole($userData['role']);

            // Assigner aux académies pour les DA
            if ($userData['role'] === 'da') {
                if (str_contains($userData['last_name'], 'Francophone')) {
                    $this->assignToAcademies($user, ['Académie Francophone Scientifique', 'Académie Francophone Littéraire'], $academies);
                } else {
                    $this->assignToAcademies($user, ['Académie Anglophone Scientifique', 'Académie Anglophone Littéraire'], $academies);
                }
            }

            $this->command->info("✓ {$userData['first_name']} {$userData['last_name']} ({$userData['role']})");
        }
    }

    /**
     * Créer le personnel de niveau ville
     */
    private function createCityStaff($cities)
    {
        $this->command->info('🏙️ Création du personnel de ville...');

        $mainCities = ['YAOUNDÉ', 'DOUALA', 'BAFOUSSAM'];

        foreach ($mainCities as $cityName) {
            if (!isset($cities[$cityName])) continue;

            $cityCode = strtolower(substr($cityName, 0, 3));
            $phoneBase = $cityName === 'YAOUNDÉ' ? '698001' : ($cityName === 'DOUALA' ? '698002' : '698003');

            $cityUsers = [
                [
                    'role' => 'ddo',
                    'first_name' => 'Directeur Délégué',
                    'last_name' => "Opérationnel {$cityName}",
                    'email' => "ddo-{$cityCode}@ima-icorp.com",
                    'phone_number' => "+237{$phoneBase}001",
                    'city_id' => $cities[$cityName],
                ],
                [
                    'role' => 'sup',
                    'first_name' => 'Superviseur',
                    'last_name' => $cityName,
                    'email' => "superviseur-{$cityCode}@ima-icorp.com",
                    'phone_number' => "+237{$phoneBase}002",
                    'city_id' => $cities[$cityName],
                ],
                [
                    'role' => 'df-v',
                    'first_name' => 'Directrice Financière',
                    'last_name' => $cityName,
                    'email' => "df-{$cityCode}@ima-icorp.com",
                    'phone_number' => "+237{$phoneBase}003",
                    'city_id' => $cities[$cityName],
                ],
                [
                    'role' => 'dl-v',
                    'first_name' => 'Directeur Logistique',
                    'last_name' => $cityName,
                    'email' => "dl-{$cityCode}@ima-icorp.com",
                    'phone_number' => "+237{$phoneBase}004",
                    'city_id' => $cities[$cityName],
                ],
                [
                    'role' => 'af',
                    'first_name' => 'Agent Financier',
                    'last_name' => $cityName,
                    'email' => "af-{$cityCode}@ima-icorp.com",
                    'phone_number' => "+237{$phoneBase}005",
                    'city_id' => $cities[$cityName],
                ],
                [
                    'role' => 'ra-v',
                    'first_name' => 'Responsable Académique',
                    'last_name' => $cityName,
                    'email' => "ra-{$cityCode}@ima-icorp.com",
                    'phone_number' => "+237{$phoneBase}006",
                    'city_id' => $cities[$cityName],
                ],
            ];

            foreach ($cityUsers as $userData) {
                $user = $this->createUser($userData);
                $user->assignRole($userData['role']);
                $this->command->info("✓ {$userData['first_name']} {$userData['last_name']} - {$cityName}");
            }
        }
    }

    /**
     * Créer le personnel de niveau centre
     */
    private function createCenterStaff($centers, $cities)
    {
        $this->command->info('🏢 Création du personnel de centre...');

        // Sélectionner quelques centres principaux pour le personnel
        $mainCenters = [
            'SIÈGE INTELLIGENTSIA' => 'siege-yde',
            'SIÈGE INTELLIGENTSIA BAFOUSSAM' => 'siege-bfs',
            'COLLÈGE POLYVALENT SUZANNA' => 'suzanna-dla',
            'COMPLEXE SCOLAIRE L\'ESPÉRANCE' => 'esperance-yde',
            'ÉCOLE PRIMAIRE LE TREMPLIN' => 'tremplin-yde',
        ];

        $phoneCounter = 1;
        foreach ($mainCenters as $centerName => $centerCode) {
            if (!isset($centers[$centerName])) continue;

            $phoneBase = "69800{$phoneCounter}";

            $centerUsers = [
                [
                    'role' => 'cc',
                    'first_name' => 'Chef de Centre',
                    'last_name' => $centerName,
                    'email' => "cc-{$centerCode}@ima-icorp.com",
                    'phone_number' => "+237{$phoneBase}01",
                    'city_id' => $this->getCityIdByCenter($centerName, $cities),
                ],
                [
                    'role' => 'ra-c',
                    'first_name' => 'Responsable Académique',
                    'last_name' => $centerName,
                    'email' => "ra-{$centerCode}@ima-icorp.com",
                    'phone_number' => "+237{$phoneBase}02",
                    'city_id' => $this->getCityIdByCenter($centerName, $cities),
                ],
                [
                    'role' => 'rf-c',
                    'first_name' => 'Responsable Financier',
                    'last_name' => $centerName,
                    'email' => "rf-{$centerCode}@ima-icorp.com",
                    'phone_number' => "+237{$phoneBase}03",
                    'city_id' => $this->getCityIdByCenter($centerName, $cities),
                ],
                [
                    'role' => 'RL-C',
                    'first_name' => 'Responsable Logistique',
                    'last_name' => $centerName,
                    'email' => "rl-{$centerCode}@ima-icorp.com",
                    'phone_number' => "+237{$phoneBase}04",
                    'city_id' => $this->getCityIdByCenter($centerName, $cities),
                ],
                [
                    'role' => 'pc',
                    'first_name' => 'Personnel',
                    'last_name' => $centerName,
                    'email' => "personnel-{$centerCode}@ima-icorp.com",
                    'phone_number' => "+237{$phoneBase}05",
                    'city_id' => $this->getCityIdByCenter($centerName, $cities),
                ],
            ];

            foreach ($centerUsers as $userData) {
                $user = $this->createUser($userData);
                $user->assignRole($userData['role']);
                $this->command->info("✓ {$userData['first_name']} - " . substr($centerName, 0, 20) . "...");
            }

            $phoneCounter++;
        }
    }

    /**
     * Créer les chefs de département
     */
    private function createDepartmentHeads($departments, $academies)
    {
        $this->command->info('👨‍🏫 Création des chefs de département...');

        // Sélectionner quelques départements principaux
        $mainDepartments = [
            'MATHÉMATIQUES' => 'maths',
            'PHYSIQUE' => 'physique',
            'CHIMIE' => 'chimie',
            'BIOLOGIE' => 'biologie',
            'ANGLAIS' => 'anglais',
            'CULTURE GENERALE' => 'culture-gen',
            'INFORMATIQUE' => 'informatique',
        ];

        $phoneCounter = 1;
        foreach ($mainDepartments as $deptName => $deptCode) {
            if (!isset($departments[$deptName])) continue;

            $phoneBase = "69801{$phoneCounter}";

            // Chef de département national
            $nationalHead = [
                'role' => 'cd-n',
                'first_name' => 'Chef Département',
                'last_name' => "{$deptName} National",
                'email' => "cd-n-{$deptCode}@ima-icorp.com",
                'phone_number' => "+237{$phoneBase}01",
                'city_id' => $this->getCityIdByName('YAOUNDÉ'),
            ];

            $user = $this->createUser($nationalHead);
            $user->assignRole($nationalHead['role']);

            // Chef de département de ville (pour Douala par exemple)
            $cityHead = [
                'role' => 'cd-v',
                'first_name' => 'Chef Département',
                'last_name' => "{$deptName} Douala",
                'email' => "cd-v-{$deptCode}@ima-icorp.com",
                'phone_number' => "+237{$phoneBase}02",
                'city_id' => $this->getCityIdByName('DOUALA'),
            ];

            $user2 = $this->createUser($cityHead);
            $user2->assignRole($cityHead['role']);

            $this->command->info("✓ Chefs Département {$deptName}");
            $phoneCounter++;
        }
    }

    /**
     * Créer un utilisateur avec les données fournies
     */
    private function createUser($userData)
    {
        return User::create([
            'first_name' => $userData['first_name'],
            'last_name' => $userData['last_name'],
            'email' => $userData['email'],
            'password' => Hash::make('password123'),
            'phone_number' => $userData['phone_number'],
            'city_id' => $userData['city_id'],
            'address' => 'Adresse administrateur',
            'account_type' => 'staff',
            'status' => User::STATUS_ACTIVE,
            'email_verified_at' => now(),
            'validated_at' => now(),
            'finalized_at' => now(),
        ]);
    }

    /**
     * Assigner un utilisateur aux académies
     */
    private function assignToAcademies($user, $academyNames, $academies)
    {
        foreach ($academyNames as $academyName) {
            if (isset($academies[$academyName])) {
                $user->academies()->attach($academies[$academyName], [
                    'role' => 'director',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Obtenir l'ID de la ville par nom de centre
     */
    private function getCityIdByCenter($centerName, $cities)
    {
        if (str_contains($centerName, 'YAOUNDÉ') || str_contains($centerName, 'SIÈGE') ||
            str_contains($centerName, 'TREMPLIN') || str_contains($centerName, 'ESPÉRANCE')) {
            return $cities['YAOUNDÉ'] ?? null;
        }

        if (str_contains($centerName, 'DOUALA') || str_contains($centerName, 'SUZANNA')) {
            return $cities['DOUALA'] ?? null;
        }

        if (str_contains($centerName, 'BAFOUSSAM')) {
            return $cities['BAFOUSSAM'] ?? null;
        }

        // Par défaut, retourner Yaoundé
        return $cities['YAOUNDÉ'] ?? null;
    }

    /**
     * Obtenir l'ID de la ville par nom
     */
    private function getCityIdByName($cityName)
    {
        return City::where('name', $cityName)->first()?->id;
    }
}
