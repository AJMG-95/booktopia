<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Datos de ejemplo para insertar
        $languages = [
            [
                'language' => 'Inglés',
                'iso_code' => 'en',
                'flag_url' => 'url_a_la_bandera_en',
            ],
            [
                'language' => 'Español',
                'iso_code' => 'es',
                'flag_url' => 'url_a_la_bandera_es',
            ],
            [
                'language' => 'Otro',
                'iso_code' => '*',
                'flag_url' => 'url_a_la_bandera_*',
            ],
        ];

        // Insertar datos en la tabla 'languages'
        DB::table('languages')->insert($languages);
    }
}
