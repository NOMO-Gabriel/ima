<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'first_name' => 'Admin',
            'last_name' => 'System',
            'email' => 'admin@ima-icorp.com',
            'password' => Hash::make('password123'),
            'status' => 'active',
            'email_verified_at' => now(),
            'validated_at' => now(),
            'finalized_at' => now(),
        ]);
        
        $admin->assignRole('PCA');
    }
}