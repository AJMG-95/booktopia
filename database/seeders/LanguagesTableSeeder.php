<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguagesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('languages')->insert([
            ['language' => 'Español', 'iso_code' => 'es'],
            ['language' => 'Inglés', 'iso_code' => 'en'],
            ['language' => 'Francés', 'iso_code' => 'fr'],
            ['language' => 'Italiano', 'iso_code' => 'it'],
            ['language' => 'Alemán', 'iso_code' => 'de'],
        ]);
    }
}

