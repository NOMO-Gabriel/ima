<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $methods = [
            ['label' => 'OM', 'name' => 'Orange Money', 'code' => '#150*47*729659*Montant#'],
            ['label' => 'MOMO', 'name' => 'Mobile Money', 'code' => '*126*4*770973*Montant#'],
            ['label' => 'CCA BANK YDE', 'name' => 'CCA BANK YAOUNDE', 'code' => '10031 01363028101 48'],
            ['label' => 'CCA BANK DLA', 'name' => 'CCA BANK DOUALA', 'code' => '10031 01363028102 45'],
            ['label' => 'UC', 'name' => 'United Credit', 'code' => '37121 04 00470'],
            ['label' => 'UBA', 'name' => 'United Bank for Africa', 'code' => '2201 60001 32'],
        ];

        DB::table('payment_methods')->insert($methods);
    }
}
