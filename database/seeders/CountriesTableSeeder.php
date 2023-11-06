<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesTableSeeder extends Seeder
{
    public function run()
    {
        $countries = [
            ['country_name' => 'España', 'iso_code' => 'ES', 'flag_url' => 'images/flags/espana.svg'],
            ['country_name' => 'Estados Unidos', 'iso_code' => 'US', 'flag_url' => 'images/flags/usa.svg'],
            ['country_name' => 'Francia', 'iso_code' => 'FR', 'flag_url' => 'images/flags/francia.svg'],
            ['country_name' => 'Italia', 'iso_code' => 'IT', 'flag_url' => 'images/flags/italia.svg'],
            ['country_name' => 'Alemania', 'iso_code' => 'DE', 'flag_url' => 'images/flags/alemania.svg'],
        ];

        DB::table('countries')->insert($countries);
    }
}
