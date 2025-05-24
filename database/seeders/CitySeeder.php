<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            
            [
                'name' => 'Mbalmayo',
                'code' => 'MBA',

                
            ],
            [
                'name' => 'Obala',
                'code' => 'OBA',
                
               
            ],

            [
                'name' => 'Edéa',
                'code' => 'EDE',
                
                
            ],
            [
                'name' => 'Nkongsamba',
                'code' => 'NKG',
                
                
            ],

            // Région de l'Ouest
            [
                'name' => 'Bafoussam',
                'code' => 'BAF',
                
            ],
            [
                'name' => 'Dschang',
                'code' => 'DSC',
                
            ],
            [
                'name' => 'Bandjoun',
                'code' => 'BDJ',
                
               
            ],

            // Région du Nord-Ouest
            [
                'name' => 'Bamenda',
                'code' => 'BMD',
                
                
            ],
            [
                'name' => 'Kumbo',
                'code' => 'KMB',
                
                
            ],

            // Région du Sud-Ouest
            [
                'name' => 'Buea',
                'code' => 'BUE',
                
                
            ],
            [
                'name' => 'Limbe',
                'code' => 'LMB',
                
                
            ],
            [
                'name' => 'Kumba',
                'code' => 'KUM',
                
                
            ],

            // Région du Nord
            [
                'name' => 'Garoua',
                'code' => 'GAR',
               
                
            ],
            [
                'name' => 'Ngaoundéré',
                'code' => 'NGA',
               
            ],

            // Région de l'Extrême-Nord
            [
                'name' => 'Maroua',
                'code' => 'MAR',
                
                
            ],

            // Région de l'Est
            [
                'name' => 'Bertoua',
                'code' => 'BER',
                
                
            ],

            // Région du Sud
            [
                'name' => 'Ebolowa',
                'code' => 'EBO',
                
                
            ],
            [
                'name' => 'Sangmélima',
                'code' => 'SAN',
                
                
            ],
        ];

        foreach ($cities as $city) {
            City::create($city);
        }
    }
}