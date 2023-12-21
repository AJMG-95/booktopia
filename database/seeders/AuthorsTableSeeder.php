<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $authors = [
            [
                'nickname' => 'anonimo',
                'name' => 'Anónimo',
                'surnames' => '',
                'birth_at' => null,
                'country_id' => null,
                'biography' => 'Autor anónimo sin información adicional.',
                'photo' => 'assets/images/authors/anonimo.jpg',
            ],
            [
                'nickname' => 'J.K. Rowling',
                'name' => 'Joanne',
                'surnames' => 'Rowling',
                'birth_at' => '1965-07-31',
                'country_id' => 2, // ID del Reino Unido según el seeder de países
                'biography' => 'British author, philanthropist, film producer, television producer, and screenwriter.',
                'photo' => 'assets/images/authors/jk_rowling.jpg',
            ],
            [
                'nickname' => 'Stephen King',
                'name' => 'Stephen',
                'surnames' => 'King',
                'birth_at' => '1947-09-21',
                'country_id' => 1, // ID de España según el seeder de países
                'biography' => 'American author of horror, supernatural fiction, suspense, crime, science-fiction, and fantasy novels.',
                'photo' => 'assets/images/authors/stephen_king.jpg',
            ],
            [
                'nickname' => 'Gabriel García Márquez',
                'name' => 'Gabriel',
                'surnames' => 'García Márquez',
                'birth_at' => '1927-03-06',
                'country_id' => 4, // ID de Colombia según el seeder de países
                'biography' => 'Colombian novelist, short-story writer, screenwriter, and journalist, known affectionately as Gabo throughout Latin America.',
                'photo' => 'assets/images/authors/gabriel_garcia_marquez.jpg',
            ],
            [
                'nickname' => 'Haruki Murakami',
                'name' => 'Haruki',
                'surnames' => 'Murakami',
                'birth_at' => '1949-01-12',
                'country_id' => 6, // ID de Japón según el seeder de países
                'biography' => 'Japanese writer. His books and stories have been bestsellers in Japan and internationally.',
                'photo' => 'assets/images/authors/haruki_murakami.jpg',
            ],
            [
                'nickname' => 'Chimamanda Ngozi Adichie',
                'name' => 'Chimamanda',
                'surnames' => 'Ngozi Adichie',
                'birth_at' => '1977-09-15',
                'country_id' => 7, // ID de Nigeria según el seeder de países
                'biography' => 'Nigerian writer known for novels such as "Half of a Yellow Sun" and "Purple Hibiscus."',
                'photo' => 'assets/images/authors/chimamanda_ngozi_adichie.jpg',
            ],
            [
                'nickname' => 'Murakami Ryu',
                'name' => 'Ryu',
                'surnames' => 'Murakami',
                'birth_at' => '1952-02-19',
                'country_id' => 8, // ID de Japón según el seeder de países
                'biography' => 'Japanese novelist and filmmaker, known for his explorations of human nature.',
                'photo' => 'assets/images/authors/murakami_ryu.jpg',
            ],
            [
                'nickname' => 'Arundhati Roy',
                'name' => 'Arundhati',
                'surnames' => 'Roy',
                'birth_at' => '1961-11-24',
                'country_id' => 11, // ID del país según el seeder de países
                'biography' => 'Indian author and activist, best known for her debut novel "The God of Small Things."',
                'photo' => 'assets/images/authors/arundhati_roy.jpg',
            ],
            [
                'nickname' => 'Jhumpa Lahiri',
                'name' => 'Jhumpa',
                'surnames' => 'Lahiri',
                'birth_at' => '1967-07-11',
                'country_id' => 9, // ID del país según el seeder de países
                'biography' => 'American author known for works like "Interpreter of Maladies" and "The Namesake."',
                'photo' => 'assets/images/authors/jhumpa_lahiri.jpg',
            ],
            [
                'nickname' => 'Agatha Christie',
                'name' => 'Agatha',
                'surnames' => 'Christie',
                'birth_at' => '1890-09-15',
                'country_id' => 2,
                'biography' => 'British writer known for her detective novels.',
                'photo' => 'assets/images/authors/agatha_christie.jpg',
            ],
            [
                'nickname' => 'George Orwell',
                'name' => 'George',
                'surnames' => 'Orwell',
                'birth_at' => '1903-06-25',
                'country_id' => 2,
                'biography' => 'English novelist, essayist, journalist, and critic.',
                'photo' => 'assets/images/authors/george_orwell.jpg',
            ],
            [
                'nickname' => 'Jane Austen',
                'name' => 'Jane',
                'surnames' => 'Austen',
                'birth_at' => '1775-12-16',
                'country_id' => 2,
                'biography' => 'English novelist known for her romantic fiction.',
                'photo' => 'assets/images/authors/jane_austen.jpg',
            ],
            [
                'nickname' => 'Leo Tolstoy',
                'name' => 'Leo',
                'surnames' => 'Tolstoy',
                'birth_at' => '1828-09-09',
                'country_id' => 3,
                'biography' => 'Russian writer known for "War and Peace" and "Anna Karenina."',
                'photo' => 'assets/images/authors/leo_tolstoy.jpg',
            ],
            [
                'nickname' => 'Mark Twain',
                'name' => 'Mark',
                'surnames' => 'Twain',
                'birth_at' => '1835-11-30',
                'country_id' => 12,
                'biography' => 'American writer and humorist, known for "The Adventures of Tom Sawyer" and "Adventures of Huckleberry Finn."',
                'photo' => 'assets/images/authors/mark_twain.jpg',
            ],
        ];

        foreach ($authors as $author) {
            DB::table('authors')->insert($author);
        }
    }
}
