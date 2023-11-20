<?php
// app/Http/Controllers/BooksController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;
use App\Models\Genre;
use App\Models\BookAuthor;
use App\Models\BookGenre;

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
        // Validación de formulario aquí si es necesario
        $request->validate([
            'original_title' => 'required|max:255',
            // Agrega otras reglas de validación según tus necesidades
        ]);

        // Crear un nuevo libro
        $book = new Book();
        $book->original_title = $request->input('original_title');
        $book->self_published = $request->has('self_published');
        $book->visible = $request->has('visible');

        // Guardar la imagen de la portada
        if ($request->hasFile('cover_image')) {
            $coverImage = $request->file('cover_image');
            $coverImageName = time() . '_' . $coverImage->getClientOriginalName();
            $coverImage->storeAs('public/book_covers', $coverImageName);
            $book->cover = 'book_covers/' . $coverImageName;
        }

        $book->save();

        // Attach autores y géneros utilizando las relaciones definidas en el modelo
        $book->authors()->attach($request->input('authors'));
        $book->genres()->attach($request->input('genres'));

        return redirect()->route('books.list')->with('success', 'Book created successfully');
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

    public function destroy($id)
    {
        // Buscar el libro por ID
        $book = Book::findOrFail($id);

        // Verificar si el libro está asociado a alguna edición
        if ($book->editions()->exists()) {
            return redirect()->route('books.list')->with('error', 'No se puede eliminar el libro porque está asociado a una edición.');
        }

        // Eliminar las relaciones en la tabla book_authors
        BookAuthor::where('book_id', $book->id)->delete();

        // Eliminar las relaciones en la tabla book_genres
        BookGenre::where('book_id', $book->id)->delete();

        // Si no está asociado a ninguna edición, proceder con la eliminación
        $book->delete();

        return redirect()->route('books.list')->with('success', 'Libro eliminado exitosamente.');
    }
}
