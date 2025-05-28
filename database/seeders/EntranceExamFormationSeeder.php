<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EntranceExamFormationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer les IDs des formations et concours
        $formations = DB::table('formations')->pluck('id', 'name')->toArray();
        $exams = DB::table('entrance_exams')->pluck('id', 'name')->toArray();

        $relations = [
            // Phase 1 Relations
            ['ENSPY - Sciences et Technologies', 'ENSP Yaoundé - Sciences et Technologies'],
            ['ENSPY - Architecture et Hydraulique Numérique', 'ENSP Yaoundé - Architecture et Hydraulique Numérique'],
            ['ENSPY - Informatique et Intelligence Artificielle', 'ENSP Yaoundé - Informatique et Intelligence Artificielle'],
            ['ENSP Douala', 'ENSP Douala'],
            ['IUT', 'Institut Universitaire de Technologie'],
            
            // Phase 2 Relations
            ['Médecine - FMSB', 'Faculté de Médecine et des Sciences Biomédicales'],
            ['Médecine - FMSB', 'Faculté de Médecine et des Sciences Pharmaceutiques'],
            ['Médecine - FMSB', 'Faculté des Sciences de la Santé Humaine'],
            ['IDE - Infirmier Diplômé d\'État', 'Infirmier Diplômé d\'État'],
            ['Sciences Biomédicales (SBM)', 'Sciences Biomédicales'],
            ['FASA', 'Faculté d\'Agronomie et des Sciences Agricoles'],
            ['ENS - Mathématiques', 'ENS - Filière Mathématiques'],
            
            // Phase 3 Relations
            ['Médecine - ESMV (PMC)', 'École Supérieure de Médecine Vétérinaire'],
            ['ENSTMO', 'École Nationale Supérieure des Travaux Maritimes et Océaniques'],
            ['ISABEE', 'ISABEE - Énergies Renouvelables et Performance Énergétique'],
            ['ISABEE', 'ISABEE - Génie de l\'Habitat'],
            ['ISABEE', 'ISABEE - Génie Rural'],
            ['ISABEE', 'ISABEE - Hydraulique, Sciences et Technologie du Bois'],
            ['ISABEE', 'ISABEE - Météorologie et Climatologie'],
            ['ENSMIP', 'École Nationale Supérieure des Mines et Industries Pétrolières'],
            ['SUP\'PTIC', 'École Nationale des Postes et Télécommunications'],
        ];

        $pivotData = [];
        foreach ($relations as $relation) {
            $formationName = $relation[0];
            $examName = $relation[1];
            
            if (isset($formations[$formationName]) && isset($exams[$examName])) {
                $pivotData[] = [
                    'formation_id' => $formations[$formationName],
                    'entrance_exam_id' => $exams[$examName],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('entrance_exam_formations')->insert($pivotData);
    }
}