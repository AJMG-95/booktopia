<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the seeder.
     *
     * @return void
     */
    public function run()
    {
        $countriesData = [
            [
                'country_name' => 'España',
                'iso_code' => 'ES',
                'flag_url' => 'images/flags/es.svg',
                'id' => '1',
            ],
            [
                'country_name' => 'Reino Unido',
                'iso_code' => 'EN',
                'flag_url' => 'images/flags/en.svg',
                'id' => '2',
            ],
            [
                'country_name' => 'Francia',
                'iso_code' => 'FR',
                'flag_url' => 'images/flags/fr.svg',
                'id' => '3',
            ],
            [
                'country_name' => 'Italia',
                'iso_code' => 'IT',
                'flag_url' => 'images/flags/it.svg',
                'id' => '4',
            ],
            [
                'country_name' => 'Alemania',
                'iso_code' => 'DE',
                'flag_url' => 'images/flags/de.svg',
                'id' => '5',
            ],
        ];

        // Insert the data into the "countries" table using Eloquent
        foreach ($countriesData as $data) {
            DB::table('countries')->insert($data);
        }
    }
}
