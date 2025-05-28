<?php
namespace Database\Seeders;

use App\Models\User;
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
        ]);

        
    }
}