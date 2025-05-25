<?php
namespace Database\Seeders;

use App\Models\EntranceExam;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CitySeeder::class,
            RolesAndPermissionsSeeder::class,
            AdminUserSeeder::class,
            CenterSeeder::class,
            EntranceExamSeeder::class,
            TestSeeder::class,

        ]);
    }
}