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
            ['direction' => 'IN', 'label' => 'DOCUMENTS'],
            ['direction' => 'IN', 'label' => 'PARTNERS'],
            ['direction' => 'IN', 'label' => 'OTHER'],

            // Expenses (OUT)
            ['direction' => 'OUT', 'label' => 'STAFF FUNCTIONING'],
            ['direction' => 'OUT', 'label' => 'TEACHER PAYMENT'],
            ['direction' => 'OUT', 'label' => 'PURCHASE'],
            ['direction' => 'OUT', 'label' => 'DOCUMENTS PRODUCTION'],
            ['direction' => 'OUT', 'label' => 'PUBLICATION AND MARKETING'],
            ['direction' => 'OUT', 'label' => 'ROOM MAINTENANCE'],
            ['direction' => 'OUT', 'label' => 'CLASS_LOCATION'],
            ['direction' => 'OUT', 'label' => 'OTHER'],
        ];

        DB::table('transaction_reasons')->insert($reasons);
    }
}
