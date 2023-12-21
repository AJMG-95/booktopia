<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Book;
use App\Models\Genre;


class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Insertar información de dos libros de J.K. Rowling en la tabla 'books'
        $jkRowlingBooks = [
            [
                'self_published' => false,
                'original_title' => 'Harry Potter and the Philosopher\'s Stone',
                'translated_title' => 'Harry Potter y la piedra filosofal',
                'short_description' => 'The first book in the Harry Potter series.',
                'description' => 'Harry discovers he is a wizard and begins his magical education.',
                'cover' => 'path/to/cover1.jpg',
                'visible' => true,
            ],
            [
                'self_published' => false,
                'original_title' => 'Harry Potter and the Chamber of Secrets',
                'translated_title' => 'Harry Potter y la cámara secreta',
                'short_description' => 'The second book in the Harry Potter series.',
                'description' => 'Harry returns to Hogwarts for his second year and encounters a series of mysterious attacks.',
                'cover' => 'path/to/cover2.jpg',
                'visible' => true,
            ],
        ];

        foreach ($jkRowlingBooks as $book) {
            $bookId = DB::table('books')->insertGetId($book);

            // Asociar los libros con J.K. Rowling en la tabla 'book_authors'
            $authorId = DB::table('authors')->where('nickname', 'J.K. Rowling')->value('id');
            DB::table('book_authors')->insert([
                'book_id' => $bookId,
                'author_id' => $authorId,
            ]);
        }

        // Insertar información de dos libros de Stephen King en la tabla 'books'
        $stephenKingBooks = [
            [
                'self_published' => false,
                'original_title' => 'The Shining',
                'translated_title' => 'El resplandor',
                'short_description' => 'A family heads to an isolated hotel for the winter where an evil presence influences the father into violence.',
                'description' => 'Considered one of Stephen King\'s most enduring works.',
                'cover' => 'path/to/cover3.jpg',
                'visible' => true,
            ],
            [
                'self_published' => false,
                'original_title' => 'It',
                'translated_title' => 'Eso',
                'short_description' => 'A group of kids in a small town must face their biggest fears when they confront an evil clown named Pennywise.',
                'description' => 'A classic horror novel by Stephen King.',
                'cover' => 'path/to/cover4.jpg',
                'visible' => true,
            ],
        ];

        foreach ($stephenKingBooks as $book) {
            $bookId = DB::table('books')->insertGetId($book);

            // Asociar los libros con Stephen King en la tabla 'book_authors'
            $authorId = DB::table('authors')->where('nickname', 'Stephen King')->value('id');
            DB::table('book_authors')->insert([
                'book_id' => $bookId,
                'author_id' => $authorId,
            ]);
        }

        // Insertar información de dos libros de Gabriel García Márquez en la tabla 'books'
        $gabrielGarciaBooks = [
            [
                'self_published' => false,
                'original_title' => 'Cien años de soledad',
                'translated_title' => 'Cien años de soledad',
                'short_description' => 'A landmark novel that tells the multi-generational story of the Buendía family in the fictional town of Macondo.',
                'description' => 'Considered one of the greatest achievements in literature.',
                'cover' => 'path/to/cover5.jpg',
                'visible' => true,
            ],
            [
                'self_published' => false,
                'original_title' => 'El amor en los tiempos del cólera',
                'translated_title' => 'El amor en los tiempos del cólera',
                'short_description' => 'A poignant love story that spans decades and explores the complexities of human relationships.',
                'description' => 'Another masterpiece by Gabriel García Márquez.',
                'cover' => 'path/to/cover6.jpg',
                'visible' => true,
            ],
        ];

        foreach ($gabrielGarciaBooks as $book) {
            $bookId = DB::table('books')->insertGetId($book);

            // Asociar los libros con Gabriel García Márquez en la tabla 'book_authors'
            $authorId = DB::table('authors')->where('nickname', 'Gabriel García Márquez')->value('id');
            DB::table('book_authors')->insert([
                'book_id' => $bookId,
                'author_id' => $authorId,
            ]);
        }

        // Insertar información de dos libros de Agatha Christie en la tabla 'books'
        $agathaChristieBooks = [
            [
                'self_published' => false,
                'original_title' => 'Murder on the Orient Express',
                'translated_title' => 'Asesinato en el Orient Express',
                'short_description' => 'A detective must solve a murder that occurred on a train.',
                'description' => 'Hercule Poirot investigates the murder of a wealthy American traveling on the famous Orient Express.',
                'cover' => 'public/assets/images/genres/mystery.jpg',
                'visible' => true,
            ],
            [
                'self_published' => false,
                'original_title' => 'And Then There Were None',
                'translated_title' => 'Diez negritos',
                'short_description' => 'Ten strangers are invited to a remote island.',
                'description' => 'A suspenseful murder mystery where each guest has a dark secret, and one by one, they are killed.',
                'cover' => 'public/assets/images/genres/mystery.jpg',
                'visible' => true,
            ],
        ];

        foreach ($agathaChristieBooks as $book) {
            $bookId = DB::table('books')->insertGetId($book);

            // Asociar los libros con Agatha Christie en la tabla 'book_authors'
            $authorId = DB::table('authors')->where('nickname', 'Agatha Christie')->value('id');
            DB::table('book_authors')->insert([
                'book_id' => $bookId,
                'author_id' => $authorId,
            ]);
        }

        // Insertar información de dos libros de George Orwell en la tabla 'books'
        $georgeOrwellBooks = [
            [
                'self_published' => false,
                'original_title' => '1984',
                'translated_title' => '1984',
                'short_description' => 'A dystopian novel set in a totalitarian society.',
                'description' => 'George Orwell\'s classic novel depicting a dystopian future where critical thought is suppressed.',
                'cover' => 'public/assets/images/books/1984.jpg',
                'visible' => true,
            ],
            [
                'self_published' => false,
                'original_title' => 'Animal Farm',
                'translated_title' => 'Rebelión en la granja',
                'short_description' => 'An allegorical novella reflecting events leading up to the Russian Revolution of 1917.',
                'description' => 'George Orwell\'s satirical tale of animals staging a rebellion to achieve a utopian society.',
                'cover' => 'public/assets/images/books/animal_farm.jpg',
                'visible' => true,
            ],
        ];

        foreach ($georgeOrwellBooks as $book) {
            $bookId = DB::table('books')->insertGetId($book);

            // Asociar los libros con George Orwell en la tabla 'book_authors'
            $authorId = DB::table('authors')->where('nickname', 'George Orwell')->value('id');
            DB::table('book_authors')->insert([
                'book_id' => $bookId,
                'author_id' => $authorId,
            ]);
        }

        // Insertar información de dos libros de Leo Tolstoy en la tabla 'books'
        $leoTolstoyBooks = [
            [
                'self_published' => false,
                'original_title' => 'War and Peace',
                'translated_title' => 'Guerra y Paz',
                'short_description' => 'Epic novel by Leo Tolstoy that depicts Russian society during the Napoleonic era.',
                'description' => 'One of the greatest novels ever written, exploring themes of love, war, and society.',
                'cover' => 'public/assets/images/covers/war_and_peace.jpg',
                'visible' => true,
            ],
            [
                'self_published' => false,
                'original_title' => 'Anna Karenina',
                'translated_title' => 'Ana Karenina',
                'short_description' => 'Tragic tale of love and infidelity in imperial Russia.',
                'description' => 'A masterful exploration of the consequences of social and moral transgressions.',
                'cover' => 'public/assets/images/covers/anna_karenina.jpg',
                'visible' => true,
            ],
        ];

        foreach ($leoTolstoyBooks as $book) {
            $bookId = DB::table('books')->insertGetId($book);

            // Asociar los libros con Leo Tolstoy en la tabla 'book_authors'
            $authorId = DB::table('authors')->where('nickname', 'Leo Tolstoy')->value('id');
            DB::table('book_authors')->insert([
                'book_id' => $bookId,
                'author_id' => $authorId,
            ]);
        }


        // ..............................................................
        // Asociar los géneros con los libros en la tabla 'book_genres'
        $bookGenres = [
            // Asociar los géneros para los libros de J.K. Rowling
            ['book_title' => 'Harry Potter and the Philosopher\'s Stone', 'genre' => 'Fantasía'],
            ['book_title' => 'Harry Potter and the Chamber of Secrets', 'genre' => 'Fantasía'],

            // Asociar los géneros para los libros de Stephen King
            ['book_title' => 'The Shining', 'genre' => 'Terror'],
            ['book_title' => 'It', 'genre' => 'Terror'],

            // Asociar los géneros para los libros de Gabriel García Márquez
            ['book_title' => 'Cien años de soledad', 'genre' => 'Desconocido'],
            ['book_title' => 'El amor en los tiempos del cólera', 'genre' => 'Ficción'],

            // Asociar los géneros para los libros de Agatha Christie
            ['book_title' => 'Murder on the Orient Express', 'genre' => 'Misterio'],
            ['book_title' => 'And Then There Were None', 'genre' => 'Misterio'],

            // Asociar los géneros para los libros de George Orwell
            ['book_title' => '1984', 'genre' => 'Desconocido'],
            ['book_title' => 'Animal Farm', 'genre' => 'Desconocido'],

            // Asociar los géneros para los libros de Leo Tolstoy
            ['book_title' => 'War and Peace', 'genre' => 'Ficción'],
            ['book_title' => 'Anna Karenina', 'genre' => 'Ficción'],
        ];

        foreach ($bookGenres as $bookGenre) {
            $book = Book::where('original_title', $bookGenre['book_title'])->first();
            $genre = Genre::where('genre', $bookGenre['genre'])->first();

            if ($book && $genre) {
                $book->genres()->attach($genre);
            }
        }
    }
}
