<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class StratenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('straten')->insert([
            ['naam' => 'Mombeekstraat', 'dorp_id'=> '1'],
            ['naam' => 'Merestraat', 'dorp_id'=> '1'],
        ]);
    }
}
