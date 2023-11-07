<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = [
            ['language' => 'Español', 'iso_code' => 'es'],
            ['language' => 'Inglés', 'iso_code' => 'en'],
            ['language' => 'Francés', 'iso_code' => 'fr'],
            ['language' => 'Italiano', 'iso_code' => 'it'],
            ['language' => 'Alemán', 'iso_code' => 'de'],
        ];

        foreach ($languages as $language) {
            \App\Models\Language::create($language);
        }
    }
}
