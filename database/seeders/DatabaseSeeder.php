<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Appeler d'abord le seeder des rôles et permissions
        $this->call([
            RolesAndPermissionsSeeder::class,
            AcademySeeder::class,
            CitySeeder::class,
            CenterSeeder::class,
            DepartmentSeeder::class,
            PhaseSeeder::class,
            FormationSeeder::class,
            EntranceExamSeeder::class,
            EntranceExamFormationSeeder::class,
            RoomSeeder::class,
            TransactionSeeder::class
        ]);


    }
}