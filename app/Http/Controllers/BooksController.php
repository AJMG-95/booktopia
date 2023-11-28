<?php
// app/Http/Controllers/BooksController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
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
        $request->validate([
            'self_published' => 'boolean',
            'original_title' => 'required|string|max:255',
            'visible' => 'boolean',
            'cover' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'authors' => 'required|array',
            'genres' => 'required|array',
        ]);

        $book = new Book();
        $book->self_published = $request->input('self_published', 0);
        $book->original_title = $request->input('original_title');
        $book->visible = $request->input('visible', 1);

        // Procesar la imagen de la portada si se proporciona
        if ($request->hasFile('cover')) {
            $image = $request->file('cover');
            $imageName = Str::slug($request->input('original_title')) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/bookCovers'), $imageName);
            $validatedData['cover'] = $imageName;
            $book->cover = $imageName;
        }

        $book->save();

        // Asignar autores al libro
        $book->authors()->attach($request->input('authors'));

        // Asignar géneros al libro
        $book->genres()->attach($request->input('genres'));

        return redirect()->route('books.list')->with('success', 'Book created successfully!');
    }


    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $authors = Author::all();
        $genres = Genre::all();

        return view('admin.management.books&editions.books.bookEdit', compact('book', 'authors', 'genres'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'self_published' => 'boolean',
            'original_title' => 'required|string|max:255',
            'visible' => 'boolean',
            'cover' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'authors' => 'required|array',
            'genres' => 'required|array',
        ]);

        $book = Book::findOrFail($id);
        $book->self_published = $request->input('self_published', 0);
        $book->original_title = $request->input('original_title');
        $book->visible = $request->input('visible', 1);

        // Procesar la imagen de la portada si se proporciona
        if ($request->hasFile('cover')) {
            $image = $request->file('cover');
            $imageName = Str::slug($request->input('original_title')) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/bookCovers'), $imageName);

            // Eliminar la imagen anterior
            if ($book->cover) {
                $coverPath = public_path('assets/images/bookCovers') . '/' . $book->cover;
                if (File::exists($coverPath)) {
                    File::delete($coverPath);
                }
            }

            $book->cover = $imageName;
        }

        $book->save();

        // Sincronizar autores y géneros
        $book->authors()->sync($request->input('authors'));
        $book->genres()->sync($request->input('genres'));

        return redirect()->route('books.list')->with('success', 'Book updated successfully!');
    }


    public function toggleVisibility($id)
    {
        // Encuentra el libro por ID
        $book = Book::findOrFail($id);

        // Cambia la visibilidad del libro
        $book->visible = !$book->visible;
        $book->save();

        // Redirecciona de vuelta a la lista de libros con un mensaje de éxito
        return redirect()->route('books.list')->with('success', 'La visibilidad del libro ha sido cambiada exitosamente.');
    }

    public function delete($id)
    {
        // Lógica para eliminar un libro
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        // Verificar si hay ediciones asociadas al libro
        if ($book->editions()->exists()) {
            return redirect()->route('books.list')->with('error', 'No puedes eliminar este libro porque tiene ediciones asociadas.');
        }

        // Eliminar la portada si existe
        if ($book->cover) {
            $coverPath = public_path('assets/images/bookCovers') . '/' . $book->cover;

            // Verificar si el archivo existe antes de intentar eliminarlo
            if (File::exists($coverPath)) {
                File::delete($coverPath);
            }
        }

        // Eliminar el libro y sus relaciones
        $book->authors()->detach();
        $book->genres()->detach();
        $book->delete();

        return redirect()->route('books.list')->with('success', 'Libro eliminado exitosamente.');
    }

    public function searchAuthors(Request $request)
    {
        $searchTerm = $request->term;

        $authors = Author::where('name', 'LIKE', '%' . $searchTerm . '%')
            ->orWhere('surnames', 'LIKE', '%' . $searchTerm . '%')
            ->get();

        return response()->json($authors);
    }

    public function randomBooks() {
        $randomBooks = Book::where('visible', true)
                        ->inRandomOrder()
                        ->take(10)
                        ->get();

        return view('welcome', compact('randomBooks'));
    }
}
