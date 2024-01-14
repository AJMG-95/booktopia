<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class FavoriteController extends Controller
{

    public function index()
    {
        $favorites = Auth::user()->favorites;
        return view('favorites.index', compact('favorites'));
    }

    /**
     * Añadir un libro a la lista de favoritos del usuario conectado.
     */
/*     public function addToFavorites(Request $request, $editionBookId)
    {
        $user = Auth::user();

        if ($user) {
            $user->favorites()->attach($editionBookId);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    } */

    /**
     * Quitar un libro de la lista de favoritos del usuario conectado.
     */
/*     public function removeFromFavorites(Request $request, $editionBookId)
    {
        $user = Auth::user();

        if ($user) {
            $user->favorites()->detach($editionBookId);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    } */
}
