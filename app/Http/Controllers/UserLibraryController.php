<?php

namespace App\Http\Controllers;

use App\Models\UserLibrary;
use App\Models\Language;
use App\Models\Author;
use App\Models\Genre;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\EditionBook;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;



class UserLibraryController extends Controller
{

    private function getBooksForUser()
    {
        return EditionBook::join('payments', 'payments.book_id', '=', 'edition_books.id')
            ->where('payments.user_id', Auth::id())
            ->get();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $books = $this->getBooksForUser();

            $authors = Author::all();
            $genres = Genre::all();
            $languages = Language::all();

            return view('layouts/user/editions/buyedEditions', compact('books', 'genres', 'authors', 'languages'));
        } catch (\Exception $e) {
            return redirect()->route('welcome')->with('error', 'Error al obtener la lista de libros.');
        }
    }


    public function search(Request $request)
    {
        try {
            $this->validateSearchRequest($request);

            $query = $this->buildEditionsQuery($request);

            // Join the payments table to get the books associated with the user
            $query->join('payments', 'payments.book_id', '=', 'edition_books.id')
                ->where('payments.user_id', Auth::id());

            $books = $this->paginateBooks($query);

            $authors = Author::all();
            $genres = Genre::all();
            $languages = Language::all();

            $userAge = Auth::user()->birth_date->age;
            $showForAdults = $userAge >= 18;


            return view('layouts/user/editions/buyedEditions', compact('books', 'authors', 'genres', 'languages', 'request', 'showForAdults'));
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
            $query->whereHas('authors', function ($q) use ($request) {
                $q->whereRaw('LOWER(name) like ?', ['%' . strtolower($request->input('author')) . '%']);
            });
        }

        if ($request->filled('genre')) {
            $query->whereHas('genres', function ($q) use ($request) {
                $q->whereRaw('LOWER(genre_name) like ?', ['%' . strtolower($request->input('genre')) . '%']);
            });
        }

        if ($request->filled('language')) {
            $query->whereHas('language', function ($q) use ($request) {
                $q->whereRaw('LOWER(language) like ?', ['%' . strtolower($request->input('language')) . '%']);
            });
        }

        if ($request->filled('language')) {
            $query->where('language_id', $request->input('language'));
        }

        if ($request->filled('for_adults')) {
            $query->where('for_adults', (bool) $request->input('for_adults'));
        }

        // Ordenar resultados según la condición seleccionada
        $sortBy = $request->input('sortBy', 'asc_price');
        $orderDirection = $request->input('orderDirection', 'desc');

        switch ($sortBy) {
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
