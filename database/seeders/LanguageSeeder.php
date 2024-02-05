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
                'language' => 'Francés',
                'iso_code' => 'fr',
                'flag_url' => 'url_a_la_bandera_fr',
            ],
            [
                'language' => 'Alemán',
                'iso_code' => 'de',
                'flag_url' => 'url_a_la_bandera_de',
            ],
            [
                'language' => 'Italiano',
                'iso_code' => 'it',
                'flag_url' => 'url_a_la_bandera_it',
            ],
            [
                'language' => 'Portugués',
                'iso_code' => 'pt',
                'flag_url' => 'url_a_la_bandera_pt',
            ],
            [
                'language' => 'Holandés',
                'iso_code' => 'nl',
                'flag_url' => 'url_a_la_bandera_nl',
            ],
            [
                'language' => 'Español (Latinoamérica)',
                'iso_code' => 'es-LA',
                'flag_url' => 'url_a_la_bandera_es_la',
            ],
            [
                'language' => 'Francés (Canadá)',
                'iso_code' => 'fr-CA',
                'flag_url' => 'url_a_la_bandera_fr_ca',
            ],
            [
                'language' => 'Español (México)',
                'iso_code' => 'es-MX',
                'flag_url' => 'url_a_la_bandera_es_mx',
            ],
        ];

        // Insertar datos en la tabla 'languages'
        DB::table('languages')->insert($languages);
    }
}
