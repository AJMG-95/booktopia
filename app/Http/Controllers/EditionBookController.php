<?php

namespace App\Http\Controllers;

use App\Models\EditionBook;
use App\Models\Language;
use App\Models\Author;
use App\Models\Genre;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;



class EditionBookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        try {
            $books = EditionBook::all();
            return view('admin.management.books.bookList', compact('books'));
        } catch (\Exception $e) {
            return redirect()->route('books.list')->with('error', 'Error al obtener la lista de libros.');
        }
    }


        /**
     * Display a listing of the resource.
     */
    public function shopList()
    {
        try {
            $authors = Author::all();
            $genres = Genre::all();
            $books = EditionBook::all();
            $languages = Language::all();
            return view('layouts/shop/editionsShop', compact('books','genres','authors', 'languages'));
        } catch (\Exception $e) {
            return redirect()->route('welcome')->with('error', 'Error al obtener la lista de libros.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $languages = Language::all();
            $authors = Author::all();
            $genres = Genre::all();

            return view('admin.management.books.bookCreate', compact('languages', 'authors', 'genres'));
        } catch (\Exception $e) {
            return redirect()->route('books.list')->with('error', 'Error al cargar el formulario de creación.');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'isbn' => 'nullable|string',
                'self_published' => 'boolean',
                'title' => 'nullable|string|max:255',
                'short_description' => 'nullable|string',
                'description' => 'nullable|string',
                'cover' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'visible' => 'boolean',
                'editorial' => 'nullable|string',
                'price' => 'nullable|numeric',
                'required' => 'nullable|file|mimes:pdf|max:2048',
                'language_id' => 'nullable|exists:languages,id',
                'for_adults' => 'boolean',
                'authors' => 'array',
                'genres' => 'array',
                // Agrega cualquier otra regla de validación según tus necesidades
            ]);

            $data = $request->all();


            $editionBook = new EditionBook($data);
            $editionBook->save();

            // Verifica si se proporcionó un archivo PDF
            if ($request->hasFile('document')) {
                $documentFile = $request->file('document');

                // Guarda el archivo PDF en el directorio correspondiente
                $documentFileName = $editionBook->id . '.pdf';  // Nombre basado en el ID del libro
                $documentPath = $documentFile->storeAs('documents', $documentFileName, 'public');

                // Asigna la ruta del documento al modelo del libro
                $editionBook->document = $documentPath;
            }

            if ($request->hasFile('cover')) {
                $coverFile = $request->file('cover');
                $coverFileName = $editionBook->id . '.' . $coverFile->getClientOriginalExtension();
                $coverPath = $coverFile->storeAs('covers', $coverFileName, 'public');

                // Actualiza la ruta de la portada en el modelo del libro
                $editionBook->cover = $coverPath;
                $editionBook->save();  // Guarda el modelo actualizado con la ruta de la portada
            }

            // Asocia los autores
            if ($request->has('authors')) {
                $editionBook->authors()->attach($request->input('authors'));
            }

            // Asocia los géneros
            if ($request->has('genres')) {
                $editionBook->genres()->attach($request->input('genres'));
            }

            return redirect()->route('books.list')->with('success', 'Libro creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('books.list')->with('error', 'Error al crear el libro.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(EditionBook $editionBook)
    {
        try {
            return view('admin.edition-books.show', compact('editionBook'));
        } catch (\Exception $e) {
            return redirect()->route('books.list')->with('error', 'Error al mostrar el libro.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EditionBook $editionBook)
    {
        try {
            $languages = Language::all();
            $authors = Author::all();
            $genres = Genre::all();

            return view('admin.management.books.bookEdit', compact('editionBook', 'languages', 'authors', 'genres'));
        } catch (\Exception $e) {
            return redirect()->route('books.list')->with('error', 'Error al cargar el formulario de edición.');
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EditionBook $editionBook)
    {
        try {
            $request->validate([
                'isbn' => 'nullable|string',
                'self_published' => 'boolean',
                'title' => 'nullable|string|max:255',
                'short_description' => 'nullable|string',
                'description' => 'nullable|string',
                'cover' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'visible' => 'boolean',
                'editorial' => 'nullable|string',
                'price' => 'nullable|numeric',
                'document' => 'nullable|string',
                'language_id' => 'nullable|exists:languages,id',
                'for_adults' => 'boolean',
                'authors' => 'array',
                'genres' => 'array',
                // Agrega cualquier otra regla de validación según tus necesidades
            ]);

            $data = $request->all();

            if ($request->hasFile('cover')) {
                $coverFile = $request->file('cover');
                $isbn = $request->input('isbn');

                // Elimina la portada anterior si existe
                if ($editionBook->cover) {
                    Storage::disk('public')->delete($editionBook->cover);
                }

                // Genera el nombre del archivo usando el campo isbn y el timestamp para evitar duplicados
                $coverFileName = $isbn . '_' . time() . '.' . $coverFile->getClientOriginalExtension();

                // Almacena la nueva imagen en el directorio correspondiente
                $coverPath = $coverFile->storeAs('covers', $coverFileName, 'public');

                $data['cover'] = $coverPath;
            }

            $editionBook->update($data);

            // Actualiza la asociación de autores
            if ($request->has('authors')) {
                $editionBook->authors()->sync($request->input('authors'));
            } else {
                // Si no se proporcionan autores, desasocia todos los autores
                $editionBook->authors()->detach();
            }

            // Actualiza la asociación de géneros
            if ($request->has('genres')) {
                $editionBook->genres()->sync($request->input('genres'));
            } else {
                // Si no se proporcionan géneros, desasocia todos los géneros
                $editionBook->genres()->detach();
            }

            return redirect()->route('books.list')->with('success', 'Libro actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('books.list')->with('error', 'Error al actualizar el libro.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
         /*    dd('ID recibido:', $id); */
            $editionBook = EditionBook::findOrFail($id);

          /*   dd('Llegó hasta aquí', $editionBook); */
            // Verificar si hay referencias en la tabla payments
            $associatedPayment = Payment::where('book_id', $editionBook->id)->first();

            if ($associatedPayment) {
                return redirect()->route('books.list')->with('error', 'No se puede eliminar el libro, está asociado a un pago.');
            }

            // Eliminar relaciones en la tabla book_authors
            $editionBook->authors()->detach();
            $editionBook->genres()->detach();

            // Continuar con la eliminación del libro
            $editionBook->delete();

            return redirect()->route('books.list')->with('success', 'Libro eliminado exitosamente.');
        } catch (\Exception $e) {
            dd('Error:', $e->getMessage());
            return redirect()->route('books.list')->with('error', 'Error al eliminar el libro.');
        }
    }

    /**
     * Obtiene una colección de libros aleatorios que son deseos de los usuarios.
     *
     * @return \Illuminate\Support\Collection
     */
    public function randomBooks()
    {
        try {
            $randomBooks = EditionBook::where('visible', true)
                ->inRandomOrder()
                ->get();

            return $randomBooks ? $randomBooks->take(10) : collect();
        } catch (\Exception $e) {
            return collect();
        }
    }
}
