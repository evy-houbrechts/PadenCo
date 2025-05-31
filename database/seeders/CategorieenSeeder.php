<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorieenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categorieen')->insert([
            ['label' => 'Man'],
            ['label' => 'Vrouw'],
            ['label' => 'Koppel'],
            ['label' => 'Onbekend'],
            ['label' => 'Slachtoffer'],
            ['label' => 'Terugkerende'],
        ]); 
    }
}
