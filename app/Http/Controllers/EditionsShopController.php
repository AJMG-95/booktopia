<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use App\Models\Edition;
use App\Models\Author;
use App\Models\Genre;
use App\Models\Language;

class EditionsShopController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Validación de entrada
            $request->validate([
                'title' => 'nullable|string|max:255',
                'author' => 'nullable|string|max:255',
                'genre' => 'nullable|string|max:255',
                'max_price' => 'nullable|numeric|min:0',
                'min_price' => 'nullable|numeric|min:0',
                'language' => 'nullable|string|max:255',
                'sortBy' => 'nullable|in:asc_price,desc_price,asc_title,desc_title,publication_date',
            ]);

            // Construir la consulta principal para las ediciones
            $query = Edition::query();

            // Incluir relaciones necesarias para evitar consultas N+1
            $query->with(['book.authors', 'language']);

            // Aplicar filtros según los parámetros de la URL

            if ($request->has('autopublicado')) {
                $query->whereHas('book', function ($q) {
                    $q->where('self_published', true);
                });
            }

            //Este filtro usa eloquent
            if ($request->filled('title')) {
                $query->where('title', 'ilike', '%' . strtolower($request->input('title')) . '%');
            }

            if ($request->filled('author')) {
                $query->whereHas('book.authors', function ($q) use ($request) {
                    $q->whereRaw('LOWER(name) like ?', ['%' . strtolower($request->input('author')) . '%']);
                });
            }

            if ($request->filled('genre')) {
                $query->whereHas('book.genres', function ($q) use ($request) {
                    $q->whereRaw('LOWER(genre) like ?', ['%' . strtolower($request->input('genre')) . '%']);
                });
            }
            if ($request->filled('max_price')) {
                $query->where('price', '<=', $request->input('max_price'));
            }

            if ($request->filled('min_price')) {
                $query->where('price', '>=', $request->input('min_price'));
            }

            if ($request->filled('language')) {
                $query->whereHas('language', function ($q) use ($request) {
                    $q->whereRaw('LOWER(language) like ?', ['%' . strtolower($request->input('language')) . '%']);
                });
            }

            // Ordenar resultados según la condición seleccionada
            $orderBy = $request->input('sortBy', 'asc_price');

            switch ($orderBy) {
                case 'asc_price':
                    $query->orderBy('price', 'asc');
                    break;
                case 'desc_price':
                    $query->orderBy('price', 'desc');
                    break;
                case 'asc_title':
                    $query->orderBy('title', 'asc');
                    break;
                case 'desc_title':
                    $query->orderBy('title', 'desc');
                    break;
                case 'publication_date':
                    $query->orderBy('publication_date', 'desc');
                    break;
            }

            // Obtener las ediciones resultantes con paginación
            $editions = $query->paginate(10); // O el número de elementos por página que prefieras

            // También puedes cargar información adicional si es necesario
            $authors = Author::all();
            $genres = Genre::all();
            $languages = Language::all();

            // Pasar los datos a la vista
            return view('layouts.shop.editionsShop', compact('editions', 'authors', 'genres', 'languages', 'request'));
        } catch (ValidationException $validationException) {
            // Manejar errores de validación
            return redirect()->back()->withErrors($validationException->errors());
        } catch (QueryException $queryException) {
            // Manejar errores de consulta de base de datos
            Log::error('Error de consulta: ' . $queryException->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error al procesar la solicitud. Por favor, intenta de nuevo.');
        } catch (\Exception $exception) {
            // Manejar otras excepciones no capturadas
            Log::error('Error inesperado: ' . $exception->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error inesperado. Por favor, intenta de nuevo.');
        }
    }
}
