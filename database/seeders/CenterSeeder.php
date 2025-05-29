<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = DB::table('cities')->pluck('id', 'name')->toArray();

        $centers = [
            [
                'name' => 'SIÈGE INTELLIGENTSIA',
                'address' => 'Montée CRADAT, 3ème étage immeuble Intelligentsia',
                'city' => 'YAOUNDÉ',
            ],
            [
                'name' => 'ÉCOLE PRIMAIRE LE TREMPLIN',
                'address' => 'Face Collège FX Vogt',
                'city' => 'YAOUNDÉ',
            ],
            [
                'name' => 'ÉCOLE PRIMAIRE LA RETRAITE',
                'address' => 'Warda derrière le collège de la Retraite',
                'city' => 'YAOUNDÉ',
            ],
            [
                'name' => 'COMPLEXE SCOLAIRE AMASIA',
                'address' => 'Derrière SNEC Ekounou',
                'city' => 'YAOUNDÉ',
            ],
            [
                'name' => 'COMPLEXE SCOLAIRE L\'ESPÉRANCE',
                'address' => 'COPES, mobile Omnisports',
                'city' => 'YAOUNDÉ',
            ],
            [
                'name' => 'GROUPE SCOLAIRE BILINGUE LES CHAMPIONS',
                'address' => 'Borne fontaine Emana',
                'city' => 'YAOUNDÉ',
            ],
            [
                'name' => 'COMPLEXE SCOLAIRE YONA',
                'address' => 'Carrefour Nkolbisson',
                'city' => 'YAOUNDÉ',
            ],
            [
                'name' => 'ÉCOLE BILINGUE AFRICAINE LES ÉTOILES',
                'address' => 'BASS, face TOTAL Jouvence',
                'city' => 'YAOUNDÉ',
            ],
            [
                'name' => 'ÉCOLE CATHOLIQUE SAINT PIERRE APÔTRE',
                'address' => 'Messamendongo, derrière le commissariat',
                'city' => 'YAOUNDÉ',
            ],
            [
                'name' => 'COLLÈGE BERCEAU DES ANGES',
                'address' => 'Neptune Simbock',
                'city' => 'YAOUNDÉ',
            ],
            [
                'name' => 'INSTITUT POLYVALENT BILINGUE TCHEUTCHOUA',
                'address' => '10e arrêt Nkoabang',
                'city' => 'YAOUNDÉ',
            ],
            [
                'name' => 'COLLÈGE BISTA',
                'address' => 'Nkolbisson, carrefour Onana',
                'city' => 'YAOUNDÉ',
            ],
            [
                'name' => 'COLLÈGE POLYVALENT SUZANNA',
                'address' => 'À 50 m face MTN Dakar',
                'city' => 'DOUALA',
            ],
            [
                'name' => 'COLLÈGE POLYVALENT NANFAH',
                'address' => 'Face parcours Vita Bonamoussadi',
                'city' => 'DOUALA',
            ],
            [
                'name' => 'ISECMA',
                'address' => '50 m du carrefour lycée de la cité des palmiers',
                'city' => 'DOUALA',
            ],
            [
                'name' => 'SOFT EDUCATION',
                'address' => 'Juste après Total NKOLBONG à Yassa',
                'city' => 'DOUALA',
            ],
            [
                'name' => 'ÉCOLE PRIMAIRE LA SOURCE',
                'address' => 'Derrière le collège MOHOUA à l\'entrée carrefour Grand moulin à Deïdo',
                'city' => 'DOUALA',
            ],
            [
                'name' => 'ÉCOLE PRIMAIRE PETIT MONDE',
                'address' => 'Quartier Grand moulin à Deïdo',
                'city' => 'DOUALA',
            ],
            [
                'name' => 'ÉCOLE PUBLIQUE DE BONABERI',
                'address' => 'Bonaberi',
                'city' => 'DOUALA',
            ],
            [
                'name' => 'ÉCOLE PRIMAIRE LAÏQUE UNITE',
                'address' => 'ILE',
                'city' => 'NKONGSAMBA',
            ],
            [
                'name' => 'SIEGE INTELLIGENTSIA BAFOUSSAM',
                'address' => 'Au-dessus de Pharmacie Madelon',
                'city' => 'BAFOUSSAM',
            ],
            [
                'name' => 'ÉCOLE PUBLIQUE DU CENTRE III-A DE BAFOUSSAM',
                'address' => 'Juste avant Lycée Bilingue de Bafoussam',
                'city' => 'BAFOUSSAM',
            ],
        ];

        foreach ($centers as $index => $center) {
            DB::table('centers')->insert([
                'name' => $center['name'],
                'code' => 'CEN' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'address' => $center['address'],
                'city_id' => $cities[$center['city']] ?? null,
                'is_active' => true,
                'director_id' => null,
                'logistics_director_id' => null,
                'finance_director_id' => null,
                'academy_id' => null,
                'staff_ids' => null,
            ]);
        }
    }
}
