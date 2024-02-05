<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insertar registros en la tabla countries
        DB::table('countries')->insert([
            [
                'country_name' => 'Estados Unidos',
                'iso_code' => 'US',
                'flag_url' => 'us_flag.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'country_name' => 'Reino Unido',
                'iso_code' => 'GB',
                'flag_url' => 'uk_flag.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'country_name' => 'Canada',
                'iso_code' => 'CA',
                'flag_url' => 'ca_flag.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'country_name' => 'España',
                'iso_code' => 'ES',
                'flag_url' => 'es_flag.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'country_name' => 'Mexico',
                'iso_code' => 'MX',
                'flag_url' => 'mx_flag.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'country_name' => 'Argentina',
                'iso_code' => 'AR',
                'flag_url' => 'ar_flag.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'country_name' => 'Colombia',
                'iso_code' => 'CO',
                'flag_url' => 'co_flag.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'country_name' => 'Peru',
                'iso_code' => 'PE',
                'flag_url' => 'pe_flag.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'country_name' => 'Chile',
                'iso_code' => 'CL',
                'flag_url' => 'cl_flag.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'country_name' => 'Venezuela',
                'iso_code' => 'VE',
                'flag_url' => 've_flag.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'country_name' => 'France',
                'iso_code' => 'FR',
                'flag_url' => 'fr_flag.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
