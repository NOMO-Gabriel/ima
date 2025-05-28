<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FormationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $phases = DB::table('phases')->pluck('id')->toArray();

        $formations = [
            // Phase 1 Formations
            [
                'name' => 'ENSPY - Sciences et Technologies',
                'description' => 'Préparation intensive pour le concours ENSP Yaoundé - Sciences et Technologies',
                'hours' => 120,
                'price' => 150000,
                'phase_id' => $phases[0] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ENSPY - Architecture et Hydraulique Numérique',
                'description' => 'Préparation intensive pour le concours ENSP Yaoundé - AHN',
                'hours' => 120,
                'price' => 150000,
                'phase_id' => $phases[0] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ENSPY - Informatique et Intelligence Artificielle',
                'description' => 'Préparation intensive pour le concours ENSP Yaoundé - IAI',
                'hours' => 120,
                'price' => 150000,
                'phase_id' => $phases[0] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ENSP Douala',
                'description' => 'Préparation intensive pour le concours ENSP Douala',
                'hours' => 120,
                'price' => 150000,
                'phase_id' => $phases[0] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'IUT',
                'description' => 'Préparation intensive pour les concours des Instituts Universitaires de Technologie',
                'hours' => 100,
                'price' => 120000,
                'phase_id' => $phases[0] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Prépa VOGT',
                'description' => 'Préparation spéciale VOGT',
                'hours' => 80,
                'price' => 100000,
                'phase_id' => $phases[0] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Phase 2 Formations
            [
                'name' => 'Médecine - FMSB',
                'description' => 'Préparation intensive pour la Faculté de Médecine et des Sciences Biomédicales',
                'hours' => 150,
                'price' => 180000,
                'phase_id' => $phases[1] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'IDE - Infirmier Diplômé d\'État',
                'description' => 'Préparation intensive pour le concours IDE',
                'hours' => 120,
                'price' => 150000,
                'phase_id' => $phases[1] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sciences Biomédicales (SBM)',
                'description' => 'Préparation intensive pour les Sciences Biomédicales',
                'hours' => 120,
                'price' => 150000,
                'phase_id' => $phases[1] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'FASA',
                'description' => 'Préparation intensive pour la Faculté d\'Agronomie et des Sciences Agricoles',
                'hours' => 120,
                'price' => 150000,
                'phase_id' => $phases[1] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ENS - Mathématiques',
                'description' => 'Préparation intensive pour l\'ENS filière Mathématiques',
                'hours' => 100,
                'price' => 130000,
                'phase_id' => $phases[1] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Phase 3 Formations
            [
                'name' => 'Médecine - ESMV (PMC)',
                'description' => 'Préparation intensive pour l\'École Supérieure de Médecine Vétérinaire',
                'hours' => 140,
                'price' => 170000,
                'phase_id' => $phases[2] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ENSTMO',
                'description' => 'Préparation intensive pour l\'École Nationale Supérieure des Travaux Maritimes et Océaniques',
                'hours' => 120,
                'price' => 150000,
                'phase_id' => $phases[2] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ISABEE',
                'description' => 'Préparation intensive pour l\'Institut Supérieur d\'Agriculture, du Bois, de l\'Eau et de l\'Environnement',
                'hours' => 120,
                'price' => 150000,
                'phase_id' => $phases[2] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ENSMIP',
                'description' => 'Préparation intensive pour l\'École Nationale Supérieure des Mines et Industries Pétrolières',
                'hours' => 120,
                'price' => 150000,
                'phase_id' => $phases[2] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'SUP\'PTIC',
                'description' => 'Préparation intensive pour l\'École Nationale des Postes et Télécommunications',
                'hours' => 100,
                'price' => 130000,
                'phase_id' => $phases[2] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('formations')->insert($formations);
    }
}