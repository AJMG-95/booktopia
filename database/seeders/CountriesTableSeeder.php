<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;

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
                'flag_url' => 'images/flags/espana.svg',
            ],
            [
                'country_name' => 'Estados Unidos',
                'iso_code' => 'US',
                'flag_url' => 'images/flags/usa.svg',
            ],
            [
                'country_name' => 'Francia',
                'iso_code' => 'FR',
                'flag_url' => 'images/flags/francia.svg',
            ],
            [
                'country_name' => 'Italia',
                'iso_code' => 'IT',
                'flag_url' => 'images/flags/italia.svg',
            ],
            [
                'country_name' => 'Alemania',
                'iso_code' => 'DE',
                'flag_url' => 'images/flags/alemania.svg',
            ],
        ];

        // Insert the data into the "countries" table using Eloquent
        foreach ($countriesData as $data) {
            Country::create($data);
        }
    }
}
