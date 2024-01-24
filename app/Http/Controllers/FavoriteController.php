<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EditionBook;

class FavoriteController extends Controller
{

    public function index()
    {
        $favorites = Auth::user()->favorites;
        return view('favorites.index', compact('favorites'));
    }

       /**
     * Añadir un libro a la lista de favoritos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addFavorite(Request $request, $id)
    {
        // Encuentra el libro por su ID
        $editionBook = EditionBook::findOrFail($id);

        // Verifica si el libro ya está en favoritos para evitar duplicados
        if (!$editionBook->isInFavorites()) {
            // Crea una nueva fila en la tabla 'favorites' asociando el libro con el usuario autenticado
            $favorite = new Favorite([
                'user_id' => auth()->id(),
            ]);

            // Asocia el libro con el favorito
            $editionBook->favorites()->save($favorite);
        }

        // Redirecciona a la página anterior o a donde desees
        return back();
    }


/**
     * Quitar un libro de la lista de favoritos.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function removeFavorite($id)
    {
        // Encuentra el libro por su ID
        $editionBook = EditionBook::findOrFail($id);

        // Obtén el favorito asociado al usuario autenticado y al libro
        $favorite = $editionBook->favorites()
            ->where('user_id', auth()->id())
            ->first();

        // Verifica si el libro está en favoritos antes de intentar eliminarlo
        if ($favorite) {
            // Elimina la fila de la tabla 'favorites'
            $favorite->delete();
        }

        // Redirecciona a la página anterior o a donde desees
        return back();
    }
}
