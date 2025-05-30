<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $formations = DB::table('formations')->pluck('id', 'name')->toArray();
        $centers = DB::table('centers')->pluck('id', 'name')->toArray(); // center_id

        $baseRooms = [
            ['capacity' => 30, 'formation_id' => $formations['ENSPY - Sciences et Technologies'] ?? null],
            ['capacity' => 30, 'formation_id' => $formations['ENSPY - Architecture et Hydraulique Numérique'] ?? null],
            ['capacity' => 25, 'formation_id' => $formations['Médecine - FMSB'] ?? null],
            ['capacity' => 20, 'formation_id' => $formations['IUT'] ?? null],
            ['capacity' => 20, 'formation_id' => $formations['IUT'] ?? null],
            ['capacity' => 20, 'formation_id' => $formations['IUT'] ?? null],
            ['capacity' => 30, 'formation_id' => $formations['ENS - Mathématiques'] ?? null],
            ['capacity' => 25, 'formation_id' => $formations['SUP\'PTIC'] ?? null],
            ['capacity' => 30, 'formation_id' => $formations['Médecine - FMSB'] ?? null],
            ['capacity' => 25, 'formation_id' => $formations['FASA'] ?? null],
            ['capacity' => 20, 'formation_id' => $formations['IDE - Infirmier Diplômé d\'État'] ?? null],
            ['capacity' => 30, 'formation_id' => $formations['Médecine - FMSB'] ?? null],
            ['capacity' => 25, 'formation_id' => $formations['Médecine - ESMV (PMC)'] ?? null],
            ['capacity' => 25, 'formation_id' => $formations['Sciences Biomédicales (SBM)'] ?? null],
            ['capacity' => 30, 'formation_id' => $formations['ENSTMO'] ?? null],
            ['capacity' => 25, 'formation_id' => $formations['ENSPY - Informatique et Intelligence Artificielle'] ?? null],
            ['capacity' => 25, 'formation_id' => null],
        ];

        $allRooms = [];
        $roomCounter = 1;

        foreach ($centers as $centerName => $centerId) {
            foreach ($baseRooms as $room) {
                $allRooms[] = [
                    'name' => 'S' . str_pad($roomCounter, 2, '0', STR_PAD_LEFT),
                    'capacity' => $room['capacity'],
                    'formation_id' => $room['formation_id'],
                    'center_id' => $centerId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                $roomCounter++;
            }
        }

        DB::table('rooms')->insert($allRooms);
    }
}
