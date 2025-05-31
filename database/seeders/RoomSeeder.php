<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $formations = DB::table('formations')->pluck('id', 'name')->toArray();

        $rooms = [
            // Phase 1 - Académie Francophone Scientifique
            [
                'capacity' => 30,
                'formation_id' => $formations['ENSPY - Sciences et Technologies'] ?? null,
            ],
            [
                'capacity' => 30,
                'formation_id' => $formations['ENSPY - Architecture et Hydraulique Numérique'] ?? null,
            ],
            [
                'capacity' => 25,
                'formation_id' => $formations['Médecine - FMSB'] ?? null,
            ],
            [
                'capacity' => 20,
                'formation_id' => $formations['IUT'] ?? null,
            ],
            [
                'capacity' => 20,
                'formation_id' => $formations['IUT'] ?? null,
            ],
            [
                'capacity' => 20,
                'formation_id' => $formations['IUT'] ?? null,
            ],

            // Phase 2 - Académie Francophone Scientifique
            [
                'capacity' => 30,
                'formation_id' => $formations['ENS - Mathématiques'] ?? null,
            ],
            [
                'capacity' => 25,
                'formation_id' => $formations['SUP\'PTIC'] ?? null,
            ],
            [
                'capacity' => 30,
                'formation_id' => $formations['Médecine - FMSB'] ?? null,
            ],
            [
                'capacity' => 25,
                'formation_id' => $formations['FASA'] ?? null,
            ],
            [
                'capacity' => 20,
                'formation_id' => $formations['IDE - Infirmier Diplômé d\'État'] ?? null,
            ],

            // Phase 3 - Académie Francophone Scientifique
            [
                'capacity' => 30,
                'formation_id' => $formations['Médecine - FMSB'] ?? null,
            ],
            [
                'capacity' => 25,
                'formation_id' => $formations['Médecine - ESMV (PMC)'] ?? null,
            ],
            [
                'capacity' => 25,
                'formation_id' => $formations['Sciences Biomédicales (SBM)'] ?? null,
            ],
            [
                'capacity' => 30,
                'formation_id' => $formations['ENSTMO'] ?? null,
            ],

            // Académie Francophone Littéraire
            [
                'capacity' => 25,
                'formation_id' => $formations['ENSPY - Informatique et Intelligence Artificielle'] ?? null,
            ],
            [
                'capacity' => 25,
                'formation_id' => null, // Pas de formation correspondante exacte dans le seeder
            ],
        ];

        // Centres
        $centers = [
            // Yaoundé
            'SIEGE INTELLIGENTSIA (Montée Cradat)',
            'ÉCOLE PRIMAIRE LE TREMPLIN (Face Collège FX Vogt)',
            'ÉCOLE PRIMAIRE LA RETRAITE (Warda)',
            'COMPLEXE SCOLAIRE AMASIA (Derrière SNEC Ekounou)',
            'COMPLEXE SCOLAIRE L\'ESPÉRANCE (COPES)',
            'GROUPE SCOLAIRE BILINGUE LES CHAMPIONS',
            'COMPLEXE SCOLAIRE YONA',
            'ÉCOLE BILINGUE AFRICAINE LES ÉTOILES',
            'COLLÈGE BERCEAU DES ANGES',
            'INSTITUT POLYVALENT BILINGUE TCHEUTCHOUA',
            'COLLÈGE BISTA',

            // Douala
            'COLLÈGE POLYVALENT SUZANNA',
            'COLLÈGE POLYVALENT NANFAH',
            'ISECMA',
            'SOFT EDUCATION',
            'ÉCOLE PRIMAIRE LA SOURCE',
            'ÉCOLE PRIMAIRE PETIT MONDE',
            'ÉCOLE PUBLIQUE DE BONABERI',

            // Autres villes
            'SIEGE INTELLIGENTSIA BAFOUSSAM',
            'ÉCOLE PUBLIQUE DU CENTRE III-A DE BAFOUSSAM',
            'ÉCOLE PRIMAIRE SAINT JOSEPH (Bafoussam)',
            'ÉCOLE PRIMAIRE D\'APPLICATION DE BANGANGTÉ',
            'ÉCOLE PRIMAIRE DU PLATEAU (Dschang)',
            'ÉCOLE PUBLIQUE SAMBA (Ebolowa)',
            'COLLÈGE ADVENTISTE DE BERTOUA',
            'COLLÈGE MODERNE DE LA BENOUÉ (Garoua)',
            'GROUPE SCOLAIRE BILINGUE BEN FATIMA (Maroua)',
        ];

        // Générer les salles S1, S2, ...
        $allRooms = [];
        $counter = 1;

        foreach ($centers as $center) {
            foreach ($rooms as $room) {
                $allRooms[] = [
                    'name' => 'S' . $counter,
                    'capacity' => $room['capacity'],
                    'formation_id' => $room['formation_id'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                $counter++;
            }
        }

        DB::table('rooms')->insert($allRooms);
    }
}
