<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Edition;
use App\Models\Author;

class EditionsShop extends Controller
{

    public function index(Request $request)
    {
        $query = Edition::query();

        //Incluir las relaciones necesarias
        $query->with(['book.author', 'language']);

        //Filtros
        if ($request->has('title')) {
            $query->where('title', 'like', '%' . $request->get('title') . '%');
        }

        if ($request->has('author')) {
            $query->whereHas('book.author', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->author . '%');
            });
        }

        if ($request->has('genre')) {
            $query->whereHas('book.genres', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->author . '%');
            });
        }
    }
}
