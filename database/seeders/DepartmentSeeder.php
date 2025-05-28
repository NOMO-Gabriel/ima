<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer les IDs des académies
        $academieScientifiqueFr = DB::table('academies')->where('code', 'AFS')->first();
        $academieLitteraireFr = DB::table('academies')->where('code', 'AFL')->first();
        $academieScientifiqueEn = DB::table('academies')->where('code', 'AAS')->first();
        $academieLitteraireEn = DB::table('academies')->where('code', 'AAL')->first();

        $departments = [
            // Départements (Matières) de l'Académie Francophone Scientifique
            [
                'name' => 'MATHÉMATIQUES',
                'code' => 'MATHS',
                'description' => 'Département de Mathématiques',
                'academy_id' => $academieScientifiqueFr?->id,
                'head_id' => null,
                'is_active' => true,
            ],
            [
                'name' => 'PHYSIQUE',
                'code' => 'PHYS',
                'description' => 'Département de Physique',
                'academy_id' => $academieScientifiqueFr?->id,
                'head_id' => null,
                'is_active' => true,
            ],
            [
                'name' => 'CHIMIE',
                'code' => 'CHIM',
                'description' => 'Département de Chimie',
                'academy_id' => $academieScientifiqueFr?->id,
                'head_id' => null,
                'is_active' => true,
            ],
            [
                'name' => 'BIOLOGIE',
                'code' => 'BIO',
                'description' => 'Département de Biologie',
                'academy_id' => $academieScientifiqueFr?->id,
                'head_id' => null,
                'is_active' => true,
            ],
            [
                'name' => 'ANGLAIS',
                'code' => 'ANG',
                'description' => 'Département d\'Anglais',
                'academy_id' => $academieScientifiqueFr?->id,
                'head_id' => null,
                'is_active' => true,
            ],
            [
                'name' => 'CULTURE GENERALE',
                'code' => 'CG',
                'description' => 'Département de Culture Générale',
                'academy_id' => $academieScientifiqueFr?->id,
                'head_id' => null,
                'is_active' => true,
            ],
            
            [
                'name' => 'INFORMATIQUE',
                'code' => 'INFO',
                'description' => 'Département d\'Informatique',
                'academy_id' => $academieScientifiqueFr?->id,
                'head_id' => null,
                'is_active' => true,
            ],
            
            // Départements (Matières) de l'Académie Francophone Littéraire
            [
                'name' => 'MATHÉMATIQUES GÉNÉRALES',
                'code' => 'MATHS_GEN',
                'description' => 'Département de Mathématiques Générales',
                'academy_id' => $academieLitteraireFr?->id,
                'head_id' => null,
                'is_active' => true,
            ],
            [
                'name' => 'MATHÉMATIQUES FINANCIÈRES',
                'code' => 'MATHS_FIN',
                'description' => 'Département de Mathématiques Financières',
                'academy_id' => $academieLitteraireFr?->id,
                'head_id' => null,
                'is_active' => true,
            ],
            [
                'name' => 'PROBABILITÉS - STATISTIQUES',
                'code' => 'PROB_STAT',
                'description' => 'Département de Probabilités et Statistiques',
                'academy_id' => $academieLitteraireFr?->id,
                'head_id' => null,
                'is_active' => true,
            ],
            [
                'name' => 'CULTURE GÉNÉRALE',
                'code' => 'CULT_GEN',
                'description' => 'Département de Culture Générale',
                'academy_id' => $academieLitteraireFr?->id,
                'head_id' => null,
                'is_active' => true,
            ],
            [
                'name' => 'CULTURE GÉNÉRALE DU NUMÉRIQUE',
                'code' => 'CULT_NUM',
                'description' => 'Département de Culture Générale du Numérique',
                'academy_id' => $academieLitteraireFr?->id,
                'head_id' => null,
                'is_active' => true,
            ],
            [
                'name' => 'DISSERTATION ÉCONOMIQUE',
                'code' => 'DISS_ECO',
                'description' => 'Département de Dissertation Économique',
                'academy_id' => $academieLitteraireFr?->id,
                'head_id' => null,
                'is_active' => true,
            ],
            [
                'name' => 'SYNTHÈSE DE DOSSIER',
                'code' => 'SYNTH_DOS',
                'description' => 'Département de Synthèse de Dossier',
                'academy_id' => $academieLitteraireFr?->id,
                'head_id' => null,
                'is_active' => true,
            ],
            [
                'name' => 'SYNTHÈSE DE DOCUMENTS',
                'code' => 'SYNTH_DOC',
                'description' => 'Département de Synthèse de Documents',
                'academy_id' => $academieLitteraireFr?->id,
                'head_id' => null,
                'is_active' => true,
            ],
            [
                'name' => 'LOGIQUE',
                'code' => 'LOGIQUE',
                'description' => 'Département de Logique',
                'academy_id' => $academieLitteraireFr?->id,
                'head_id' => null,
                'is_active' => true,
            ],
            [
                'name' => 'RÉDACTION',
                'code' => 'REDAC',
                'description' => 'Département de Rédaction',
                'academy_id' => $academieLitteraireFr?->id,
                'head_id' => null,
                'is_active' => true,
            ],
            [
                'name' => 'DISSERTATION',
                'code' => 'DISSERT',
                'description' => 'Département de Dissertation',
                'academy_id' => $academieLitteraireFr?->id,
                'head_id' => null,
                'is_active' => true,
            ],
            [
                'name' => 'COMPRÉHENSION DE TEXTE',
                'code' => 'COMP_TEXT',
                'description' => 'Département de Compréhension de Texte',
                'academy_id' => $academieLitteraireFr?->id,
                'head_id' => null,
                'is_active' => true,
            ],
            [
                'name' => 'ART ORATOIRE',
                'code' => 'ART_ORAT',
                'description' => 'Département d\'Art Oratoire',
                'academy_id' => $academieLitteraireFr?->id,
                'head_id' => null,
                'is_active' => true,
            ],
            [
                'name' => 'MÉTHODOLOGIE',
                'code' => 'METHOD',
                'description' => 'Département de Méthodologie',
                'academy_id' => $academieLitteraireFr?->id,
                'head_id' => null,
                'is_active' => true,
            ],
            [
                'name' => 'LITTÉRATURE ET LANGUE',
                'code' => 'LITT_LANG',
                'description' => 'Département de Littérature et Langue',
                'academy_id' => $academieLitteraireFr?->id,
                'head_id' => null,
                'is_active' => true,
            ],
            [
                'name' => 'HISTOIRE',
                'code' => 'HIST',
                'description' => 'Département d\'Histoire',
                'academy_id' => $academieLitteraireFr?->id,
                'head_id' => null,
                'is_active' => true,
            ],
            [
                'name' => 'GÉOGRAPHIE',
                'code' => 'GEOG',
                'description' => 'Département de Géographie',
                'academy_id' => $academieLitteraireFr?->id,
                'head_id' => null,
                'is_active' => true,
            ],

            // Matières communes aux deux académies francophones
            [
                'name' => 'ANGLAIS',
                'code' => 'ANG_FR',
                'description' => 'Département d\'Anglais - Académie Francophone Scientifique',
                'academy_id' => $academieScientifiqueFr?->id,
                'head_id' => null,
                'is_active' => true,
            ],
            [
                'name' => 'ANGLAIS',
                'code' => 'ANG_AFL',
                'description' => 'Département d\'Anglais - Académie Francophone Littéraire',
                'academy_id' => $academieLitteraireFr?->id,
                'head_id' => null,
                'is_active' => true,
            ],

            // Départements (Matières) pour les Académies Anglophones
            [
                'name' => 'MATHEMATICS',
                'code' => 'MATH_EN',
                'description' => 'Mathematics Department',
                'academy_id' => $academieScientifiqueEn?->id,
                'head_id' => null,
                'is_active' => true,
            ],
            [
                'name' => 'PHYSICS',
                'code' => 'PHYS_EN',
                'description' => 'Physics Department',
                'academy_id' => $academieScientifiqueEn?->id,
                'head_id' => null,
                'is_active' => true,
            ],
            [
                'name' => 'CHEMISTRY',
                'code' => 'CHEM_EN',
                'description' => 'Chemistry Department',
                'academy_id' => $academieScientifiqueEn?->id,
                'head_id' => null,
                'is_active' => true,
            ],
            [
                'name' => 'BIOLOGY',
                'code' => 'BIO_EN',
                'description' => 'Biology Department',
                'academy_id' => $academieScientifiqueEn?->id,
                'head_id' => null,
                'is_active' => true,
            ],
            [
                'name' => 'ENGLISH LANGUAGE',
                'code' => 'ENG_LANG',
                'description' => 'English Language Department',
                'academy_id' => $academieLitteraireEn?->id,
                'head_id' => null,
                'is_active' => true,
            ],
            [
                'name' => 'LITERATURE',
                'code' => 'LIT_EN',
                'description' => 'Literature Department',
                'academy_id' => $academieLitteraireEn?->id,
                'head_id' => null,
                'is_active' => true,
            ],
            [
                'name' => 'GENERAL KNOWLEDGE',
                'code' => 'GEN_KNOW',
                'description' => 'General Knowledge Department',
                'academy_id' => $academieLitteraireEn?->id,
                'head_id' => null,
                'is_active' => true,
            ],
            [
                'name' => 'FRENCH',
                'code' => 'FRENCH',
                'description' => 'French Language Department',
                'academy_id' => $academieLitteraireEn?->id,
                'head_id' => null,
                'is_active' => true,
            ],
        ];

        // Insérer les départements (matières)
        $departmentsCreated = 0;
        foreach ($departments as $department) {
            if ($department['academy_id']) {
                DB::table('departments')->insert([
                    'name' => $department['name'],
                    'code' => $department['code'],
                    'description' => $department['description'],
                    'academy_id' => $department['academy_id'],
                    'head_id' => $department['head_id'],
                    'is_active' => $department['is_active'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $departmentsCreated++;
            }
        }

        // Message de confirmation
        $this->command->info("✅ {$departmentsCreated} départements (matières) créés avec succès");
    }
}