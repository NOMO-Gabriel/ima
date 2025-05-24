<?php

namespace Database\Seeders;

use App\Models\EntranceExam;
use Illuminate\Database\Seeder;

class EntranceExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $entranceExams = [
            [
                'code' => 'ENS',
                'name' => 'École Normale Supérieure',
            ],
            [
                'code' => 'ENAM',
                'name' => 'École Nationale d\'Administration et de Magistrature',
            ],
            [
                'code' => 'ENSP',
                'name' => 'École Nationale Supérieure Polytechnique',
            ],
            [
                'code' => 'ENSAI',
                'name' => 'École Nationale Supérieure Agronomique et Industrielle',
            ],
            [
                'code' => 'IUT',
                'name' => 'Institut Universitaire de Technologie',
            ],
            [
                'code' => 'ENSET',
                'name' => 'École Normale Supérieure d\'Enseignement Technique',
            ],
            [
                'code' => 'FMSB',
                'name' => 'Faculté de Médecine et des Sciences Biomédicales',
            ],
            [
                'code' => 'FALSH',
                'name' => 'Faculté des Arts, Lettres et Sciences Humaines',
            ],
            [
                'code' => 'FSJP',
                'name' => 'Faculté des Sciences Juridiques et Politiques',
            ],
            [
                'code' => 'FSEG',
                'name' => 'Faculté des Sciences Économiques et de Gestion',
            ],
        ];

        foreach ($entranceExams as $exam) {
            EntranceExam::create($exam);
        }
    }
}