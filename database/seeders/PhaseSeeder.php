<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PhasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $phases = [
            // 1ère Phase
            [
                'description' => '1ère PHASE INTENSIVE 2025 - Formations ENSPY, ENSPD, IUT, MEDECINE, INGENIEUR, etc.',
                'start' => Carbon::create(2025, 6, 2)->format('Y-m-d'), // 02 juin 2025
                'end' => Carbon::create(2025, 7, 12)->format('Y-m-d'), // 12 juillet 2025
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // 2ème Phase
            [
                'description' => '2ème PHASE INTENSIVE 2025 - Formations MEDECINE, IDE, SBM, FASA, INGENIEUR, etc.',
                'start' => Carbon::create(2025, 7, 7)->format('Y-m-d'), // 07 juillet 2025
                'end' => Carbon::create(2025, 8, 30)->format('Y-m-d'), // 30 août 2025
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // 3ème Phase
            [
                'description' => '3ème PHASE INTENSIVE 2025 - Formations MEDECINE, ENSTMO, ISABEE, ENSMIP, EGEM, etc.',
                'start' => Carbon::create(2025, 8, 1)->format('Y-m-d'), // 01 août 2025
                'end' => Carbon::create(2025, 10, 4)->format('Y-m-d'), // 04 octobre 2025
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('phases')->insert($phases);
    }
}