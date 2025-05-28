<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reasons = [
            // Revenues (IN)
            ['type' => 'IN', 'label' => 'DOCUMENTS'],
            ['type' => 'IN', 'label' => 'PARTNERS'],
            ['type' => 'IN', 'label' => 'OTHER'],

            // Expenses (OUT)
            ['type' => 'OUT', 'label' => 'STAFF FUNCTIONING'],
            ['type' => 'OUT', 'label' => 'TEACHER PAYMENT'],
            ['type' => 'OUT', 'label' => 'PURCHASE'],
            ['type' => 'OUT', 'label' => 'DOCUMENTS PRODUCTION'],
            ['type' => 'OUT', 'label' => 'PUBLICATION AND MARKETING'],
            ['type' => 'OUT', 'label' => 'ROOM MAINTENANCE'],
            ['type' => 'OUT', 'label' => 'CLASS_LOCATION'],
            ['type' => 'OUT', 'label' => 'OTHER'],
        ];

        DB::table('transaction_reasons')->insert($reasons);
    }
}
