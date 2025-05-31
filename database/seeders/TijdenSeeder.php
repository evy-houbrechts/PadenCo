<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class TijdenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tijden')->insert([
            ['moment' => 'ochtend'],
            ['moment' => 'vroege avond'],
            ['moment' => 'late avond'],
        ]);
    }

}
