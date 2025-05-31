<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;

class SoortenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('soorten')->insert([
            ['naam' => 'Pad', 'kan_koppels' => true],
    ['naam' => 'Bruine kikker', 'kan_koppels' => true],
    ['naam' => 'Groene kikker', 'kan_koppels' => true],
    ['naam' => 'Kleine watersalamander', 'kan_koppels' => false],
    ['naam' => 'Alpenwatersalamander', 'kan_koppels' => false],
]);
    }
}
