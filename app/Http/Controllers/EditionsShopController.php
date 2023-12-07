<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Edition;
use App\Models\Author;
use App\Models\Genre;

class EditionsShopController extends Controller
{
    public function index(Request $request)
    {
        // Construir la consulta principal para las ediciones
        $query = Edition::query();

        // Incluir relaciones necesarias para evitar consultas N+1
        $query->with(['book.authors', 'language']); // Corrección: 'book.author' a 'book.authors'

        // Aplicar filtros según los parámetros de la solicitud
        if ($request->has('title')) {
            $query->where('title', 'like', '%' . $request->get('title') . '%');
        }

        if ($request->has('author')) {
            $query->whereHas('book.authors', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->get('author') . '%');
            });
        }

        if ($request->has('genre')) {
            $query->whereHas('book.genres', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->get('genre') . '%');
            });
        }

        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->get('max_price'));
        }

        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->get('min_price'));
        }

        // Otros filtros...

        // Ordenar resultados según la condición seleccionada
        $orderBy = $request->get('sortBy', 'asc_price');

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
            // Agrega más casos según sea necesario
        }

        // Obtener las ediciones resultantes
        $editions = $query->get();

        // También puedes cargar información adicional si es necesario
        $authors = Author::all();
        $genres = Genre::all();

        // Pasar los datos a la vista
        return view('layouts.shop.editionsShop', compact('editions', 'authors', 'genres'));
    }
}

