<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            ['language' => 'Estadounidense', 'iso_code' => 'us'],
            ['language' => 'Canadiense', 'iso_code' => 'ca'],
            ['language' => 'Australiano', 'iso_code' => 'au'],
            ['language' => 'Portugués', 'iso_code' => 'br'],
            ['language' => 'Japonés', 'iso_code' => 'jp'],
            ['language' => 'Hindi', 'iso_code' => 'in'],
            ['language' => 'Mexicano', 'iso_code' => 'mx'],
            ['language' => 'Chino', 'iso_code' => 'cn'],
            ['language' => 'Sudafricano', 'iso_code' => 'za'],
            ['language' => 'Ruso', 'iso_code' => 'ru'],
        ];

        foreach ($languages as $data) {
            DB::table('languages')->insert($data);
        }
    }
}

