<?php

namespace Database\Seeders;

use App\Models\Center;
use App\Models\City;
use App\Models\Academy;
use Illuminate\Database\Seeder;

class CenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer les académies
        $academieFrancophone = Academy::where('name', 'Académie Francophone')->first();
        $academieAnglophone = Academy::where('name', 'Académie Anglophone')->first();

        // Récupérer les villes
        $cities = City::all();

        // Centres pour les principales villes
        $centersData = [
            // YAOUNDÉ - Centres multiples
            'Yaoundé' => [
                [
                    'name' => 'Centre IMA Yaoundé Essos',
                    'code' => 'YDE-ESS',
                    'academy_id' => $academieFrancophone->id,
                    'address' => 'Quartier Essos, Avenue Kennedy',
                    'contact_email' => 'essos@ima-icorp.com',
                    'contact_phone' => '+237 222 223 344',
                ],
                [
                    'name' => 'Centre IMA Yaoundé Melen',
                    'code' => 'YDE-MEL',
                    'academy_id' => $academieFrancophone->id,
                    'address' => 'Quartier Melen, Route de l\'Aéroport',
                    'contact_email' => 'melen@ima-icorp.com',
                    'contact_phone' => '+237 222 334 455',
                ],
                [
                    'name' => 'Centre IMA Yaoundé Emombo',
                    'code' => 'YDE-EMO',
                    'academy_id' => $academieFrancophone->id,
                    'address' => 'Quartier Emombo, Carrefour Warda',
                    'contact_email' => 'emombo@ima-icorp.com',
                    'contact_phone' => '+237 222 445 566',
                ],
            ],
            
            // DOUALA - Centres multiples
            'Douala' => [
                [
                    'name' => 'Centre IMA Douala Akwa',
                    'code' => 'DLA-AKW',
                    'academy_id' => $academieFrancophone->id,
                    'address' => 'Quartier Akwa, Boulevard de la Liberté',
                    'contact_email' => 'akwa@ima-icorp.com',
                    'contact_phone' => '+237 233 445 566',
                ],
                [
                    'name' => 'Centre IMA Douala Bonanjo',
                    'code' => 'DLA-BON',
                    'academy_id' => $academieFrancophone->id,
                    'address' => 'Quartier Bonanjo, Rue Joss',
                    'contact_email' => 'bonanjo@ima-icorp.com',
                    'contact_phone' => '+237 233 556 677',
                ],
                [
                    'name' => 'Centre IMA Douala Makepe',
                    'code' => 'DLA-MAK',
                    'academy_id' => $academieFrancophone->id,
                    'address' => 'Quartier Makepe, Carrefour Makepe',
                    'contact_email' => 'makepe@ima-icorp.com',
                    'contact_phone' => '+237 233 667 788',
                ],
            ],

            // BAFOUSSAM
            'Bafoussam' => [
                [
                    'name' => 'Centre IMA Bafoussam',
                    'code' => 'BAF-CTR',
                    'academy_id' => $academieFrancophone->id,
                    'address' => 'Quartier Tamdja, Route de Bamenda',
                    'contact_email' => 'bafoussam@ima-icorp.com',
                    'contact_phone' => '+237 233 778 899',
                ],
            ],

            // BAMENDA - Centre anglophone
            'Bamenda' => [
                [
                    'name' => 'IMA Center Bamenda',
                    'code' => 'BMD-CTR',
                    'academy_id' => $academieAnglophone->id,
                    'address' => 'Commercial Avenue, Up Station',
                    'contact_email' => 'bamenda@ima-icorp.com',
                    'contact_phone' => '+237 233 889 900',
                ],
            ],

            // BUEA - Centre anglophone
            'Buea' => [
                [
                    'name' => 'IMA Center Buea',
                    'code' => 'BUE-CTR',
                    'academy_id' => $academieAnglophone->id,
                    'address' => 'Molyko Quarter, University Road',
                    'contact_email' => 'buea@ima-icorp.com',
                    'contact_phone' => '+237 233 990 011',
                ],
            ],

            // GAROUA
            'Garoua' => [
                [
                    'name' => 'Centre IMA Garoua',
                    'code' => 'GAR-CTR',
                    'academy_id' => $academieFrancophone->id,
                    'address' => 'Quartier Plateau, Avenue du 27 Août',
                    'contact_email' => 'garoua@ima-icorp.com',
                    'contact_phone' => '+237 233 101 122',
                ],
            ],

            // NGAOUNDÉRÉ
            'Ngaoundéré' => [
                [
                    'name' => 'Centre IMA Ngaoundéré',
                    'code' => 'NGA-CTR',
                    'academy_id' => $academieFrancophone->id,
                    'address' => 'Quartier Haoussa, Route de Garoua',
                    'contact_email' => 'ngaoundere@ima-icorp.com',
                    'contact_phone' => '+237 233 212 233',
                ],
            ],

            // BERTOUA
            'Bertoua' => [
                [
                    'name' => 'Centre IMA Bertoua',
                    'code' => 'BER-CTR',
                    'academy_id' => $academieFrancophone->id,
                    'address' => 'Quartier Centre-ville, Avenue de l\'Indépendance',
                    'contact_email' => 'bertoua@ima-icorp.com',
                    'contact_phone' => '+237 233 323 344',
                ],
            ],

            // EBOLOWA
            'Ebolowa' => [
                [
                    'name' => 'Centre IMA Ebolowa',
                    'code' => 'EBO-CTR',
                    'academy_id' => $academieFrancophone->id,
                    'address' => 'Quartier Cité Verte, Route d\'Ambam',
                    'contact_email' => 'ebolowa@ima-icorp.com',
                    'contact_phone' => '+237 233 434 455',
                ],
            ],

            // DSCHANG
            'Dschang' => [
                [
                    'name' => 'Centre IMA Dschang',
                    'code' => 'DSC-CTR',
                    'academy_id' => $academieFrancophone->id,
                    'address' => 'Quartier Fongo-Ndeng, Route universitaire',
                    'contact_email' => 'dschang@ima-icorp.com',
                    'contact_phone' => '+237 233 545 566',
                ],
            ],

            // Centres supplémentaires dans d'autres villes
            'Mbalmayo' => [
                [
                    'name' => 'Centre IMA Mbalmayo',
                    'code' => 'MBA-CTR',
                    'academy_id' => $academieFrancophone->id,
                    'address' => 'Centre-ville, Route de Yaoundé',
                    'contact_email' => 'mbalmayo@ima-icorp.com',
                    'contact_phone' => '+237 233 656 677',
                ],
            ],

            'Edéa' => [
                [
                    'name' => 'Centre IMA Edéa',
                    'code' => 'EDE-CTR',
                    'academy_id' => $academieFrancophone->id,
                    'address' => 'Quartier Commercial, Route de Douala',
                    'contact_email' => 'edea@ima-icorp.com',
                    'contact_phone' => '+237 233 767 788',
                ],
            ],

            'Kumba' => [
                [
                    'name' => 'IMA Center Kumba',
                    'code' => 'KUM-CTR',
                    'academy_id' => $academieAnglophone->id,
                    'address' => 'Fiango Quarter, Mamfe Road',
                    'contact_email' => 'kumba@ima-icorp.com',
                    'contact_phone' => '+237 233 878 899',
                ],
            ],
        ];

        // Créer les centres
        foreach ($centersData as $cityName => $centersList) {
            $city = $cities->where('name', $cityName)->first();
            
            if ($city) {
                foreach ($centersList as $centerData) {
                    Center::create([
                        'name' => $centerData['name'],
                        'code' => $centerData['code'],
                        'description' => "Centre de formation IMA-ICORP situé à {$cityName}",
                        'academy_id' => $centerData['academy_id'],
                        'city_id' => $city->id,
                        'address' => $centerData['address'],
                        'contact_email' => $centerData['contact_email'],
                        'contact_phone' => $centerData['contact_phone'],
                        'is_active' => true,
                    ]);
                }
            }
        }

        $this->command->info('Centres créés avec succès!');
    }
}