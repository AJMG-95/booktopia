<?php
// app/Http/Controllers/BooksAndEditionsController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BooksAndEditionsController extends Controller
{
    public function index()
    {
        return view('admin.management.books&editions.index');
    }

    public function toggleVisibility($id)
    {
        $book = Book::findOrFail($id);

        // Verifica la visibilidad actual y cambia el estado
        $book->visible = !$book->visible;
        $book->save();

        $message = $book->visible ? 'Libro marcado como visible.' : 'Libro marcado como no visible.';

        return redirect()->route('books&editions.books.list')->with('success', $message);
    }
}
