<?php
// app/Http/Controllers/BooksController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;
use App\Models\Genre;

class BooksController extends Controller
{

    public function index()
    {
        $books = Book::all();
        return view('admin.management.books&editions.books.bookList', compact('books'));
    }

    public function create()
    {
        // Obtener la lista de autores existentes
        $authors = Author::all();
        $genres = Genre::all();

        // Lógica para mostrar el formulario de creación con la lista de autores
        return view('admin.management.books&editions.books.bookCreate', compact('authors', 'genres'));
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'original_title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'published_date' => 'nullable|date',
            'cover_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'self_published' => 'nullable|boolean',
            'visible' => 'nullable|boolean',
            'authors' => 'required|array',
            'authors.*' => 'exists:authors,id',
            'genres' => 'required|array',
            'genres.*' => 'exists:genres,id',
        ]);

        // Subir la imagen de la portada y obtener la ruta almacenada
        $coverImagePath = $request->file('cover_image')->store('public/assets/images/covers');

        // Crear el libro utilizando el modelo específico
        $book = new Book([
            'original_title' => $validatedData['original_title'],
            'description' => $validatedData['description'],
            'published_date' => $validatedData['published_date'],
            'cover_image' => $coverImagePath,
            'self_published' => $validatedData['self_published'] ?? false,
            'visible' => $validatedData['visible'] ?? true,
        ]);

        // Guardar el libro en la base de datos
        $book->save();

        // Adjuntar autores al libro
        $book->authors()->attach($validatedData['authors']);

        // Adjuntar géneros al libro
        $book->genres()->attach($validatedData['genres']);

        return redirect()->route('books.list')->with('success', 'Libro creado exitosamente.');
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        return view('admin.books.edit', compact('book'));
    }

    public function searchAuthors(Request $request)
    {
        $searchTerm = $request->term;

        $authors = Author::where('name', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('surnames', 'LIKE', '%' . $searchTerm . '%')
            ->get();

        return response()->json($authors);
    }

    public function update(Request $request, $id)
    {
        // Lógica para actualizar un libro
    }

    public function delete($id)
    {
        // Lógica para eliminar un libro
    }
}
