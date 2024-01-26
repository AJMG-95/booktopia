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
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\BookComment;

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
            $books = EditionBook::where('visible', true)->get();
            $languages = Language::all();
            return view('layouts/shop/editionsShop', compact('books', 'genres', 'authors', 'languages'));
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
                'document' => 'file|mimes:pdf|max:2048',
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
    public function show($id)
    {
        try {
            $editionBook = EditionBook::findOrFail($id);
            $comments = BookComment::where('book_id', $editionBook->id)->get();

            return view('components/book/bookDetail', compact('editionBook', 'comments'));
        } catch (\Exception $e) {
            return redirect()->route('books.list')->with('error', 'Error al mostrar el libro.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $editionBook = EditionBook::findOrFail($id);
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


    public function toggleVisibility($id)
    {
        try {
            $editionBook = EditionBook::findOrFail($id);
            $editionBook->update(['visible' => !$editionBook->visible]);

            return redirect()->route('books.list')->with('success', 'Visibilidad del libro actualizada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('books.list')->with('error', 'Error al actualizar la visibilidad del libro.');
        }
    }



    public function search(Request $request)
    {
        try {
            $this->validateSearchRequest($request);

            $query = $this->buildEditionsQuery($request);

            $books = $this->paginateBooks($query);

            $authors = Author::all();
            $genres = Genre::all();
            $languages = Language::all();


            if (Auth::check()) {
                $userAge = Auth::user()->birth_date->age;
                $showForAdults = $userAge >= 18;
                return view('layouts.shop.editionsShop', compact('books', 'authors', 'genres', 'languages', 'request', 'showForAdults'));
            }

            return view('layouts.shop.editionsShop', compact('books', 'authors', 'genres', 'languages', 'request'));
        } catch (ValidationException $validationException) {
            return redirect()->back()->withErrors($validationException->errors());
        } catch (QueryException $queryException) {
            Log::error('Error de consulta: ' . $queryException->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error al procesar la solicitud. Por favor, intenta de nuevo.');
        } catch (\Exception $exception) {
            Log::error('Error inesperado: ' . $exception->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error inesperado. Por favor, intenta de nuevo.');
        }
    }

    private function validateSearchRequest(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'author' => 'nullable|string|max:255',
            'genre' => 'nullable|string|max:255',
            'min_price' => [
                'nullable',
                'regex:/^\d+(\,\d{1,2})?$/',
            ],
            'max_price' => [
                'nullable',
                'regex:/^\d+(\,\d{1,2})?$/',
            ],
            'language' => 'nullable|string|max:255',
            'autopublicado' => 'nullable|boolean',
            'for_adults' => 'nullable|boolean',
            'sortBy' => 'nullable|in:asc_price,desc_price,asc_title,desc_title,publication_date',
        ]);
    }

    private function buildEditionsQuery(Request $request)
    {
        $query = EditionBook::query();
        $query->with(['authors', 'genres', 'language']);

        // Aplicar filtros según los parámetros de la URL

        if ($request->has('autopublicado')) {
            $query->where('self_published', true);
        }

        if ($request->filled('title')) {
            $query->where('title', 'ilike', '%' . strtolower($request->input('title')) . '%');
        }

        if ($request->filled('author')) {
            $authorSearchTerm = strtolower($request->input('author'));

            $query->whereHas('authors', function ($q) use ($authorSearchTerm) {
                $q->whereRaw('LOWER(name) like ?', ['%' . $authorSearchTerm . '%'])
                    ->orWhereRaw('LOWER(surnames) like ?', ['%' . $authorSearchTerm . '%'])
                    ->orWhereRaw('LOWER(nickname) like ?', ['%' . $authorSearchTerm . '%'])
                    ->orWhereRaw('CONCAT(LOWER(name), \' \', LOWER(surnames)) like ?', ['%' . $authorSearchTerm . '%']);
            });

            if (!$query->exists()) {
                // Si no hay resultados con el término completo, buscar por partes (nombre, apellido, apodo)
                $query->whereHas('authors', function ($q) use ($authorSearchTerm) {
                    $names = explode(' ', $authorSearchTerm);
                    foreach ($names as $namePart) {
                        $q->whereRaw('LOWER(name) like ? or LOWER(surnames) like ? or LOWER(nickname) like ?', [
                            '%' . $namePart . '%',
                            '%' . $namePart . '%',
                            '%' . $namePart . '%',
                        ]);
                    }
                });
            }
        }


        if ($request->filled('genre')) {
            $query->whereHas('genres', function ($q) use ($request) {
                $q->whereRaw('LOWER(genre_name) like ?', ['%' . strtolower($request->input('genre')) . '%']);
            });
        }

        if ($request->filled('max_price') && $request->filled('min_price')) {
            $maxPrice = str_replace(',', '.', $request->input('max_price'));
            $minPrice = str_replace(',', '.', $request->input('min_price'));

            if ($maxPrice < $minPrice) {
                return redirect()->back()->with('error', 'El valor para el precio máximo debe ser superior o igual al valor para el precio mínimo');
            } else {
                $query->whereBetween('price', [$minPrice, $maxPrice]);
            }
        } elseif ($request->filled('min_price')) {
            $query->where('price', '>=', str_replace(',', '.', $request->input('min_price')));
        } elseif ($request->filled('max_price')) {
            $query->where('price', '<=', str_replace(',', '.', $request->input('max_price')));
        }

        if ($request->filled('language')) {
            // Puedes combinar estas dos condiciones
            $query->whereHas('language', function ($q) use ($request) {
                $q->whereRaw('LOWER(language) like ?', ['%' . strtolower($request->input('language')) . '%']);
            })->orWhere('language_id', $request->input('language'));
        }

        if ($request->filled('for_adults')) {
            $query->where('for_adults', (bool) $request->input('for_adults'));
        }

        // Agregar condición para mostrar solo los libros visibles
        $query->where('visible', true);

        // Ordenar resultados según la condición seleccionada
        $sortBy = $request->input('sortBy', 'asc_price');
        $orderDirection = $request->input('orderDirection', 'desc');

        switch ($sortBy) {
            case 'asc_price':
                $query->orderBy('price', $orderDirection);
                break;
            case 'desc_price':
                $query->orderBy('price', $orderDirection === 'asc' ? 'desc' : 'asc');
                break;
            case 'asc_title':
                $query->orderBy('title', $orderDirection);
                break;
            case 'desc_title':
                $query->orderBy('title', $orderDirection === 'asc' ? 'desc' : 'asc');
                break;
            default:
                $query->orderBy('publication_date', $orderDirection);
                break;
        }

        return $query;
    }



    private function paginateBooks($query)
    {
        return $query->paginate(10);
    }
}
