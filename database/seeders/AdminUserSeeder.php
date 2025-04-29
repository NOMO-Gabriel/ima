<?php

namespace Database\Seeders;


    use App\Models\User;
    use App\Models\Academy;
    use App\Models\Department;
    use App\Models\Center;
    use App\Models\City;
    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\Hash;

    class AdminUserSeeder extends Seeder
    {
        public function run(): void
        {
            // Création des villes
            $yaounde = City::create(['name' => 'Yaoundé', 'code' => 'YDE']);
            $douala = City::create(['name' => 'Douala', 'code' => 'DLA']);

            // Création des académies
            $academieFrancophone = Academy::create([
                'name' => 'Académie Francophone',
                'description' => 'Académie des programmes francophones',
                'is_active' => true
            ]);

            $academieAnglophone = Academy::create([
                'name' => 'Académie Anglophone',
                'description' => 'Académie des programmes anglophones',
                'is_active' => true
            ]);

            // Création des départements
            $departements = [
                'Mathématiques' => 'Département des mathématiques',
                'Physique' => 'Département de physique',
                'Chimie' => 'Département de chimie',
                'Biologie' => 'Département de biologie'
            ];

            foreach ($departements as $nom => $description) {
                Department::create([
                    'name' => $nom,
                    'description' => $description,
                    'academy_id' => $academieFrancophone->id,
                    'is_active' => true
                ]);

                Department::create([
                    'name' => $nom,
                    'description' => $description . ' (Anglophone)',
                    'academy_id' => $academieAnglophone->id,
                    'is_active' => true
                ]);
            }

            // Création des centres
            $centres = [
                'Centre Bastos' => ['city_id' => $yaounde->id, 'academy_id' => $academieFrancophone->id],
                'Centre Bonanjo' => ['city_id' => $douala->id, 'academy_id' => $academieFrancophone->id],
                'Centre Biyem-Assi' => ['city_id' => $yaounde->id, 'academy_id' => $academieFrancophone->id],
                'Centre Akwa' => ['city_id' => $douala->id, 'academy_id' => $academieAnglophone->id],
                'Centre Ngoa-Ekelle' => ['city_id' => $yaounde->id, 'academy_id' => $academieAnglophone->id],
            ];

            foreach ($centres as $nom => $data) {
                Center::create([
                    'name' => $nom,
                    'description' => 'Centre de formation ' . $nom,
                    'city_id' => $data['city_id'],
                    'academy_id' => $data['academy_id'],
                    'is_active' => true ,
                    'address' => 'Adresse de ' . $nom
                ]);
            }

            // Création des utilisateurs avec rôles nationaux
            $this->createNationalUsers();

            // Création des utilisateurs avec rôles de ville
            $this->createCityUsers();

            // Création des utilisateurs avec rôles de centre
            $this->createCenterUsers();

            // Création des enseignants et élèves
            $this->createTeachersAndStudents();

            // Création des utilisateurs externes
            $this->createExternalUsers();
        }

        /**
         * Créer les utilisateurs de niveau national
         */
        private function createNationalUsers(): void
        {
            $nationalRoles = ['pca', 'dg-prepas', 'sg', 'da', 'df-national', 'dln'];

            foreach ($nationalRoles as $role) {
                $user = User::create([
                    'first_name' => 'National',
                    'last_name' => $role,
                    'email' => 'national' . $role . '@ima-icorp.com',
                    'password' => Hash::make('password123'),
                    'status' => 'active',
                    'email_verified_at' => now(),
                    'validated_at' => now(),
                    'finalized_at' => now(),
                'phone_number' => '237' . rand(600000000, 699999999),
                ]);

                $user->myAssignRole($role);
            }
        }

        /**
         * Créer les utilisateurs de niveau ville
         */
        private function createCityUsers(): void
        {
            $cities = City::all();
            $cityRoles = ['df-ville', 'agent-financier', 'dl-ville', 'chef-departement'];

            foreach ($cities as $city) {
                foreach ($cityRoles as $role) {
                    $user = User::create([
                        'first_name' => $city->name,
                        'last_name' => $role,
                        'email' => strtolower($city->code) . $role . '@ima-icorp.com',
                        'password' => Hash::make('password123'),
                        'status' => 'active',
                        'email_verified_at' => now(),
                        'validated_at' => now(),
                        'finalized_at' => now(),
                    'phone_number' => '237' . rand(600000000, 699999999),
                        'city_id' => $city->id
                    ]);

                    // $user->myAssignRole($role);
                }
            }

            // Créer un chef de département pour chaque département
            $departments = Department::all();
            foreach ($departments as $department) {
                $academy = Academy::find($department->academy_id);
                // Créer un identifiant unique basé sur l'académie
                $academySuffix = $academy->name === 'Académie Francophone' ? 'fr' : 'en';
                $user = User::create([
                    'first_name' => 'Chef',
                    'last_name' => $department->name,
                    'email' => 'chef.' . strtolower(str_replace(' ', '', $department->name)) . '.' . $academySuffix . '@ima-icorp.com',
                    'password' => Hash::make('password123'),
                    'status' => 'active',
                    'email_verified_at' => now(),
                    'validated_at' => now(),
                    'finalized_at' => now(),
                'phone_number' => '237' . rand(600000000, 699999999),
                    'academy_id' => $department->academy_id,
                    'department_id' => $department->id
                ]);

                $user->myAssignRole('chef-departement');
            }
        }

        /**
         * Créer les utilisateurs de niveau centre
         */
        private function createCenterUsers(): void
        {
            $centers = Center::all();
            $centerRoles = ['chef-centre', 'resp-academique', 'resp-financier', 'resp-logistique', 'personnel-centre'];

            foreach ($centers as $center) {
                foreach ($centerRoles as $role) {
                    $user = User::create([
                        'first_name' => str_replace('Centre ', '', $center->name),
                        'last_name' => $role,
                        'email' => strtolower(str_replace(['Centre ', ' ', '-'], ['', '.', ''], $center->name)) . '.' . strtolower(str_replace('-', '', $role)) . '@ima-icorp.com',
                        'password' => Hash::make('password123'),
                        'status' => 'active',
                        'email_verified_at' => now(),
                        'validated_at' => now(),
                        'finalized_at' => now(),
                    'phone_number' => '237' . rand(600000000, 699999999),
                        'city_id' => $center->city_id,
                        'academy_id' => $center->academy_id,
                        'center_id' => $center->id
                    ]);

                    $user->myAssignRole($role);
                }
            }
        }

        /**
         * Créer des enseignants et élèves
         */
        private function createTeachersAndStudents(): void
        {
            $centers = Center::all();
            $departments = Department::all();


            // Créer 2 enseignants par département
            foreach ($departments as $department) {
                // Déterminer le suffixe de l'académie
            $academy = Academy::find($department->academy_id);
            $academySuffix = $academy->name === 'Académie Francophone' ? 'fr' : 'en';
                for ($i = 1; $i <= 2; $i++) {
                    $user = User::create([
                        'first_name' => 'Enseignant' . $i,
                        'last_name' => $department->name,
                        'email' => 'enseignant' . $i . '.' . strtolower(str_replace(' ', '', $department->name)) . '.' . $academySuffix . '@ima-icorp.com',
                        'password' => Hash::make('password123'),
                        'status' => 'active',
                        'email_verified_at' => now(),
                        'validated_at' => now(),
                        'finalized_at' => now(),
                    'phone_number' => '237' . rand(600000000, 699999999),
                        'academy_id' => $department->academy_id,
                        'department_id' => $department->id
                    ]);

                    $user->myAssignRole('enseignant');
                }
            }

            // Créer 5 élèves par centre
            foreach ($centers as $center) {
                for ($i = 1; $i <= 5; $i++) {
                    $user = User::create([
                        'first_name' => 'Eleve' . $i,
                        'last_name' => str_replace('Centre ', '', $center->name),
                        'email' => 'eleve' . $i . '.' . strtolower(str_replace(['Centre ', ' '], ['', ''], $center->name)) . '@ima-icorp.com',
                        'password' => Hash::make('password123'),
                        'status' => 'active',
                        'email_verified_at' => now(),
                        'validated_at' => now(),
                        'finalized_at' => now(),
                    'phone_number' => '237' . rand(600000000, 699999999),
                        'city_id' => $center->city_id,
                        'academy_id' => $center->academy_id,
                        'center_id' => $center->id
                    ]);

                    $user->myAssignRole('eleve');
                }
            }
        }

        /**
         * Créer des utilisateurs externes
         */
        private function createExternalUsers(): void
        {
            // Créer quelques parents
            $eleves = User::role('eleve')->get();

            foreach ($eleves as $index => $eleve) {
                if ($index % 2 == 0) { // Créer un parent pour un élève sur deux
                    $user = User::create([
                        'first_name' => 'Parent',
                        'last_name' => $eleve->last_name,
                        'email' => 'parent.' . strtolower($eleve->first_name) . '.' . strtolower($eleve->last_name) . '@gmail.com',
                        'password' => Hash::make('password123'),
                        'status' => 'active',
                        'email_verified_at' => now(),
                        'validated_at' => now(),
                        'finalized_at' => now(),
                    'phone_number' => '237' . rand(600000000, 699999999),
                        'city_id' => $eleve->city_id
                    ]);

                    $user->myAssignRole('parent');
                }
            }

            // Créer un compte de service pour les notifications
            $user = User::create([
                'first_name' => 'Service',
                'last_name' => 'Notification',
                'email' => 'notification@ima-icorp.com',
                'password' => Hash::make('password123'),
                'status' => 'active',
                'email_verified_at' => now(),
                'validated_at' => now(),
                'finalized_at' => now(),
            'phone_number' => '237600000000',
            ]);

            $user->myAssignRole('service-notification');
        }
    }