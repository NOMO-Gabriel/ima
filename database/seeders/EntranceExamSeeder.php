<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EntranceExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $exams = [
            // ENSP Yaoundé
            [
                'code' => 'ENSPY-ST',
                'name' => 'ENSP Yaoundé - Sciences et Technologies',
            ],
            [
                'code' => 'ENSPY-AHN',
                'name' => 'ENSP Yaoundé - Architecture et Hydraulique Numérique',
            ],
            [
                'code' => 'ENSPY-IAI',
                'name' => 'ENSP Yaoundé - Informatique et Intelligence Artificielle',
            ],

            // ENSP Douala
            [
                'code' => 'ENSPD',
                'name' => 'ENSP Douala',
            ],

            // Faculté de Médecine
            [
                'code' => 'FMSB',
                'name' => 'Faculté de Médecine et des Sciences Biomédicales',
            ],
            [
                'code' => 'FMSP',
                'name' => 'Faculté de Médecine et des Sciences Pharmaceutiques',
            ],
            [
                'code' => 'FSH',
                'name' => 'Faculté des Sciences de la Santé Humaine',
            ],
            [
                'code' => 'UDM',
                'name' => 'Université des Montagnes - Médecine',
            ],
            [
                'code' => 'ISTM',
                'name' => 'Institut Supérieur des Techniques Médicales',
            ],

            // Écoles de Commerce et Gestion
            [
                'code' => 'ESSEC',
                'name' => 'École Supérieure des Sciences Économiques et Commerciales',
            ],
            [
                'code' => 'HICM',
                'name' => 'Hautes Études Commerciales et Managériales',
            ],
            [
                'code' => 'UCAC',
                'name' => 'Université Catholique d\'Afrique Centrale',
            ],

            // Écoles des Postes et Télécoms
            [
                'code' => 'SUP\'PTIC',
                'name' => 'École Nationale des Postes et Télécommunications',
            ],

            // Écoles des Travaux Publics
            [
                'code' => 'ENSTP',
                'name' => 'École Nationale Supérieure des Travaux Publics',
            ],

            // IUT
            [
                'code' => 'IUT',
                'name' => 'Institut Universitaire de Technologie',
            ],

            // Agronomie
            [
                'code' => 'FASA',
                'name' => 'Faculté d\'Agronomie et des Sciences Agricoles',
            ],

            // Géologie et Mines
            [
                'code' => 'ENSMIP',
                'name' => 'École Nationale Supérieure des Mines et Industries Pétrolières',
            ],
            [
                'code' => 'EGEM',
                'name' => 'École de Géologie et d\'Exploitation Minière',
            ],
            [
                'code' => 'EGCIM',
                'name' => 'École de Géologie, des Mines et des Industries Chimiques',
            ],

            // Paramédical
            [
                'code' => 'IDE',
                'name' => 'Infirmier Diplômé d\'État',
            ],
            [
                'code' => 'SBM',
                'name' => 'Sciences Biomédicales',
            ],
            [
                'code' => 'ESMV',
                'name' => 'École Supérieure de Médecine Vétérinaire',
            ],
            [
                'code' => 'ISH',
                'name' => 'Institut des Sciences de la Santé',
            ],
            [
                'code' => 'ENSAHV',
                'name' => 'École Nationale Supérieure d\'Agriculture et de l\'Hydraulique Vétérinaire',
            ],

            // Écoles Normales Supérieures
            [
                'code' => 'ENS-MATH',
                'name' => 'ENS - Filière Mathématiques',
            ],
            [
                'code' => 'ENS-PHY',
                'name' => 'ENS - Filière Physique-Chimie',
            ],
            [
                'code' => 'ENS-BIO',
                'name' => 'ENS - Filière Biologie',
            ],
            [
                'code' => 'ENS-LMF',
                'name' => 'ENS - Lettres Modernes Françaises',
            ],
            [
                'code' => 'ENS-LB',
                'name' => 'ENS - Lettres Bilingues',
            ],
            [
                'code' => 'ENS-HG',
                'name' => 'ENS - Histoire-Géographie',
            ],

            // ISABEE
            [
                'code' => 'ISABEE-ERPE',
                'name' => 'ISABEE - Énergies Renouvelables et Performance Énergétique',
            ],
            [
                'code' => 'ISABEE-GH',
                'name' => 'ISABEE - Génie de l\'Habitat',
            ],
            [
                'code' => 'ISABEE-GR',
                'name' => 'ISABEE - Génie Rural',
            ],
            [
                'code' => 'ISABEE-HSTE',
                'name' => 'ISABEE - Hydraulique, Sciences et Technologie du Bois',
            ],
            [
                'code' => 'ISABEE-MC',
                'name' => 'ISABEE - Météorologie et Climatologie',
            ],
            [
                'code' => 'ISABEE-AESH',
                'name' => 'ISABEE - Agriculture, Élevage et Science Halieutiques',
            ],
            [
                'code' => 'ISABEE-FSTB',
                'name' => 'ISABEE - Foresterie, Sciences et Technologie du Bois',
            ],
            [
                'code' => 'ISABEE-ESVA',
                'name' => 'ISABEE - Économie, Sociologie Rurale et Vulgarisation Agricole',
            ],
            [
                'code' => 'ISABEE-SE',
                'name' => 'ISABEE - Sciences de l\'Environnement',
            ],
            [
                'code' => 'ISABEE-ARCH',
                'name' => 'ISABEE - Architecture',
            ],

            // Autres
            [
                'code' => 'ESSTIC',
                'name' => 'École Supérieure des Sciences et Techniques de l\'Information et de la Communication',
            ],
            [
                'code' => 'INJS',
                'name' => 'Institut National de la Jeunesse et des Sports',
            ],
            [
                'code' => 'ENSTMO',
                'name' => 'École Nationale Supérieure des Travaux Maritimes et Océaniques',
            ],
            [
                'code' => 'ENSPM',
                'name' => 'École Nationale Supérieure Polytechnique de Maroua',
            ],
            [
                'code' => 'ESTM',
                'name' => 'École Supérieure des Techniques Médicales',
            ],
            [
                'code' => 'DOUANE',
                'name' => 'École Nationale des Douanes',
            ],
            [
                'code' => 'ENIEG',
                'name' => 'École Nationale des Ingénieurs des Eaux et Forêts',
            ],
        ];

        DB::table('entrance_exams')->insert($exams);
    }
}