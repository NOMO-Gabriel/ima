<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcademySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $academies = [
            [
                'name' => 'Académie Francophone Scientifique',
                'code' => 'AFS',
                'description' => 'Académie dédiée aux disciplines scientifiques en langue française',
                'director_id' => null,
                'created_by' => null,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Académie Francophone Littéraire',
                'code' => 'AFL',
                'description' => 'Académie dédiée aux disciplines littéraires en langue française',
                'director_id' => null,
                'created_by' => null,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Académie Anglophone Scientifique',
                'code' => 'AAS',
                'description' => 'Académie dédiée aux disciplines scientifiques en langue anglaise',
                'director_id' => null,
                'created_by' => null,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Académie Anglophone Littéraire',
                'code' => 'AAL',
                'description' => 'Académie dédiée aux disciplines littéraires en langue anglaise',
                'director_id' => null,
                'created_by' => null,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('academies')->insert($academies);
        // Message de confirmation
        $this->command->info('✅ 4 académies créées avec succès');
    }

    
}
