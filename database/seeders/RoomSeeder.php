<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
                'name' => 'FORMATION ECOLES D\'INGENIERIE 1',
                'capacity' => 30,
                'formation_id' => $formations['ENSPY - Sciences et Technologies'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'FORMATION ECOLE D\'INGENIERIE 2',
                'capacity' => 30,
                'formation_id' => $formations['ENSPY - Architecture et Hydraulique Numérique'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'FORMATION ECOLES DE SANTE ET D\'INGENIERIE',
                'capacity' => 25,
                'formation_id' => $formations['Médecine - FMSB'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'FORMATION IUT - SPECIALITE GC',
                'capacity' => 20,
                'formation_id' => $formations['IUT'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'FORMATION IUT SPECIALITE GEII - GBM',
                'capacity' => 20,
                'formation_id' => $formations['IUT'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'FORMATION IUT SPECIALITE GI - GL - GRT',
                'capacity' => 20,
                'formation_id' => $formations['IUT'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Phase 2 - Académie Francophone Scientifique
            [
                'name' => 'FORMATION ECOLES D\'INGENIERIE 1 (Phase 2)',
                'capacity' => 30,
                'formation_id' => $formations['ENS - Mathématiques'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'FORMATION ECOLES D\'INGENIERIE 2: SUP\'PTIC - ENSPD ALTERNANCE',
                'capacity' => 25,
                'formation_id' => $formations['SUP\'PTIC'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'FORMATION ECOLES DE MEDECINE & PARAMEDICALE',
                'capacity' => 30,
                'formation_id' => $formations['Médecine - FMSB'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'FORMATION ECOLES D\'INGENIERIE 2: FASA',
                'capacity' => 25,
                'formation_id' => $formations['FASA'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'FORMATION ECOLES DE SANTE IDE',
                'capacity' => 20,
                'formation_id' => $formations['IDE - Infirmier Diplômé d\'État'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Phase 3 - Académie Francophone Scientifique
            [
                'name' => 'FORMATION FACULTE DE MEDECINE',
                'capacity' => 30,
                'formation_id' => $formations['Médecine - FMSB'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'FORMATION ECOLES DE SANTE 1',
                'capacity' => 25,
                'formation_id' => $formations['Médecine - ESMV (PMC)'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'FORMATION ECOLES DE SANTE 2',
                'capacity' => 25,
                'formation_id' => $formations['Sciences Biomédicales (SBM)'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'FORMATION ECOLES D\'INGENIERIE 1 (Phase 3)',
                'capacity' => 30,
                'formation_id' => $formations['ENSTMO'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Académie Francophone Littéraire
            [
                'name' => 'FORMATION ECOLES D\'INFORMATIQUE',
                'capacity' => 25,
                'formation_id' => $formations['ENSPY - Informatique et Intelligence Artificielle'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'FORMATION ECOLES DE GESTION ESSEC - HICM',
                'capacity' => 25,
                'formation_id' => null, // Pas de formation correspondante exacte dans le seeder
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Ajouter les salles pour chaque centre
        $centers = [
            // Centres de Yaoundé
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
            
            // Centres de Douala
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
            'GROUPE SCOLAIRE BILINGUE BEN FATIMA (Maroua)'
        ];

        $allRooms = [];
        foreach ($centers as $center) {
            foreach ($rooms as $room) {
                $allRooms[] = [
                    'name' => $room['name'] . ' - ' . $center,
                    'capacity' => $room['capacity'],
                    'formation_id' => $room['formation_id'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('rooms')->insert($allRooms);
    }
}