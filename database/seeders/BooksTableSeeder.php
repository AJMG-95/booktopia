<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
    }
}
