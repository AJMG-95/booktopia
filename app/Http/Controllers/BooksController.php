<?php
// app/Http/Controllers/BooksController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;

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
    $existingAuthors = Author::all();

    // Lógica para mostrar el formulario de creación con la lista de autores
    return view('admin.management.books&editions.books.bookCreate', compact('existingAuthors'));
}

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'author_id' => 'required|exists:authors,id',
            'self_published' => 'required|boolean',
            'original_title' => 'required|string|max:255',
            'cover' => 'nullable|string|max:255',
            'visible' => 'required|boolean',
        ]);

        // Crear el libro utilizando el modelo específico
        $book = Book::create($validatedData);

        // Asociar géneros al libro si se han seleccionado
        if ($request->has('genres')) {
            $book->genres()->sync($request->input('genres'));
        }

        // Redirigir a la lista de libros con un mensaje de éxito
        return redirect()->route('books&editions.index')->with('success', 'Libro creado exitosamente.');
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

