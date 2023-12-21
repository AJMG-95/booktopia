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
            ],
            [
                'country_name' => 'Reino Unido',
                'iso_code' => 'EN',
                'flag_url' => 'images/flags/en.svg',
            ],
            [
                'country_name' => 'Francia',
                'iso_code' => 'FR',
                'flag_url' => 'images/flags/fr.svg',
            ],
            [
                'country_name' => 'Italia',
                'iso_code' => 'IT',
                'flag_url' => 'images/flags/it.svg',
            ],
            [
                'country_name' => 'Alemania',
                'iso_code' => 'DE',
                'flag_url' => 'images/flags/de.svg',
            ],
            [
                'country_name' => 'Estados Unidos',
                'iso_code' => 'US',
                'flag_url' => 'images/flags/us.svg',
            ],
            [
                'country_name' => 'Canadá',
                'iso_code' => 'CA',
                'flag_url' => 'images/flags/ca.svg',
            ],
            [
                'country_name' => 'Australia',
                'iso_code' => 'AU',
                'flag_url' => 'images/flags/au.svg',
            ],
            [
                'country_name' => 'Brasil',
                'iso_code' => 'BR',
                'flag_url' => 'images/flags/br.svg',
            ],
            [
                'country_name' => 'Japón',
                'iso_code' => 'JP',
                'flag_url' => 'images/flags/jp.svg',
            ],
            [
                'country_name' => 'India',
                'iso_code' => 'IN',
                'flag_url' => 'images/flags/in.svg',
            ],
            [
                'country_name' => 'México',
                'iso_code' => 'MX',
                'flag_url' => 'images/flags/mx.svg',
            ],
            [
                'country_name' => 'China',
                'iso_code' => 'CN',
                'flag_url' => 'images/flags/cn.svg',
            ],
            [
                'country_name' => 'Sudáfrica',
                'iso_code' => 'ZA',
                'flag_url' => 'images/flags/za.svg',
            ],
            [
                'country_name' => 'Rusia',
                'iso_code' => 'RU',
                'flag_url' => 'images/flags/ru.svg',
            ],
        ];

        // Insert the data into the "countries" table using Eloquent
        foreach ($countriesData as $data) {
            DB::table('countries')->insert($data);
        }
    }
}
