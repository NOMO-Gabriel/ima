<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            // RÉGION DU CENTRE
            [
                'name' => 'YAOUNDÉ',
                'code' => 'YDE',
                'is_active' => true,
            ],

            // RÉGION DU LITTORAL
            [
                'name' => 'DOUALA',
                'code' => 'DLA',
                'is_active' => true,
            ],
            [
                'name' => 'NKONGSAMBA',
                'code' => 'NKG',
                'is_active' => true,
            ],

            // RÉGION DE L'OUEST
            [
                'name' => 'BAFOUSSAM',
                'code' => 'BFS',
                'is_active' => true,
            ],
            [
                'name' => 'BANGANGTÉ',
                'code' => 'BGT',
                'is_active' => true,
            ],
            [
                'name' => 'DSCHANG',
                'code' => 'DSC',
                'is_active' => true,
            ],

            // RÉGION DU SUD
            [
                'name' => 'EBOLOWA',
                'code' => 'EBL',
                'is_active' => true,
            ],

            // RÉGION DE L'EST
            [
                'name' => 'BERTOUA',
                'code' => 'BRT',
                'is_active' => true,
            ],

            // RÉGION DU GRAND NORD (NORD ET EXTRÊME-NORD)
            [
                'name' => 'GAROUA',
                'code' => 'GRA',
                'is_active' => true,
            ],
            [
                'name' => 'MAROUA',
                'code' => 'MRA',
                'is_active' => true,
            ],

           
        ];

        foreach ($cities as $city) {
            DB::table('cities')->insert([
                'name' => $city['name'],
                'code' => $city['code'],
                'is_active' => $city['is_active'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}