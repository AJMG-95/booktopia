<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genres = [
            [
                'genre' => 'Ficción',
                'description' => 'Género literario que engloba obras literarias creadas por la imaginación y no basadas en la realidad.',
                'img_url' => 'assets/images/genres/ficcion.jpg',
            ],
            [
                'genre' => 'Misterio',
                'description' => 'Género literario que se caracteriza por la presencia del suspense, intriga y situaciones enigmáticas.',
                'img_url' => 'assets/images/genres/misterio.jpg',
            ],
            [
                'genre' => 'Romance',
                'description' => 'Género literario centrado en las relaciones amorosas entre los personajes.',
                'img_url' => 'assets/images/genres/romance.jpg',
            ],
            [
                'genre' => 'Ciencia Ficción',
                'description' => 'Género literario que mezcla elementos científicos y tecnológicos con elementos de la ficción.',
                'img_url' => 'assets/images/genres/ciencia_ficcion.jpg',
            ],
            [
                'genre' => 'Fantasía',
                'description' => 'Género literario que incluye elementos mágicos y sobrenaturales.',
                'img_url' => 'assets/images/genres/fantasia.jpg',
            ],
            [
                'genre' => 'Aventura',
                'description' => 'Género literario que se centra en las experiencias emocionantes y peligrosas de los personajes.',
                'img_url' => 'assets/images/genres/aventura.jpg',
            ],
            [
                'genre' => 'Histórico',
                'description' => 'Género literario basado en hechos históricos y ambientado en el pasado.',
                'img_url' => 'assets/images/genres/historico.jpg',
            ],
            [
                'genre' => 'Thriller',
                'description' => 'Género literario que busca mantener la tensión y el suspense a lo largo de la narrativa.',
                'img_url' => 'assets/images/genres/thriller.jpg',
            ],
            [
                'genre' => 'Drama',
                'description' => 'Género literario que se centra en la representación de situaciones conflictivas y emotivas.',
                'img_url' => 'assets/images/genres/drama.jpg',
            ],
            [
                'genre' => 'Comedia',
                'description' => 'Género literario que busca provocar la risa y el buen humor en el lector.',
                'img_url' => 'assets/images/genres/comedia.jpg',
            ],
            [
                'genre' => 'Suspenso',
                'description' => 'Género literario que busca mantener la atención del lector mediante situaciones de incertidumbre.',
                'img_url' => 'assets/images/genres/suspenso.jpg',
            ],
            [
                'genre' => 'Horror',
                'description' => 'Género literario que busca provocar miedo y terror en el lector.',
                'img_url' => 'assets/images/genres/horror.jpg',
            ],
            [
                'genre' => 'Poesía',
                'description' => 'Género literario que se caracteriza por el uso estilizado del lenguaje para expresar sentimientos y emociones.',
                'img_url' => 'assets/images/genres/poesia.jpg',
            ],
            [
                'genre' => 'No Ficción',
                'description' => 'Género literario que aborda temas reales y basados en hechos verídicos.',
                'img_url' => 'assets/images/genres/no_ficcion.jpg',
            ],
            [
                'genre' => 'Biografía',
                'description' => 'Género literario que narra la vida de una persona real.',
                'img_url' => 'assets/images/genres/biografia.jpg',
            ],
            [
                'genre' => 'Autoayuda',
                'description' => 'Género literario que busca ayudar al lector a mejorar aspectos de su vida.',
                'img_url' => 'assets/images/genres/autoayuda.jpg',
            ],
            [
                'genre' => 'Negocios',
                'description' => 'Género literario que aborda temas relacionados con el mundo empresarial y la gestión.',
                'img_url' => 'assets/images/genres/negocios.jpg',
            ],
            [
                'genre' => 'Cocina',
                'description' => 'Género literario que se centra en la preparación de alimentos y recetas culinarias.',
                'img_url' => 'assets/images/genres/cocina.jpg',
            ],
            [
                'genre' => 'Ciencia',
                'description' => 'Género literario que explora temas científicos y descubrimientos.',
                'img_url' => 'assets/images/genres/ciencia.jpg',
            ],
            [
                'genre' => 'Viajes',
                'description' => 'Género literario que narra experiencias de viaje y descubrimientos de lugares.',
                'img_url' => 'assets/images/genres/viajes.jpg',
            ],
            [
                'genre' => 'Desconocido',
                'description' => 'No existe el género.',
                'img_url' => 'assets/images/genres/desconocido.jpg',
            ],
        ];

        foreach ($genres as $genre) {
            DB::table('genres')->insert($genre);
        }
    }
}
