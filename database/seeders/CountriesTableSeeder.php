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
                'country_name' => 'United States',
                'iso_code' => 'US',
                'flag_url' => 'us_flag.jpg', // Puedes reemplazarlo con una URL real
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'country_name' => 'United Kingdom',
                'iso_code' => 'GB',
                'flag_url' => 'uk_flag.jpg', // Puedes reemplazarlo con una URL real
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'country_name' => 'Canada',
                'iso_code' => 'CA',
                'flag_url' => 'ca_flag.jpg', // Puedes reemplazarlo con una URL real
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Agrega más países según sea necesario
        ]);
    }
}
