<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{

    public function index()
    {
        $favorites = Auth::user()->favorites;
        return view('favorites.index', compact('favorites'));
    }

    public function addToFavorites(Request $request, $editionBookId)
    {
        $user = User::find(auth()->user()->id);

        // Verifica si ya existe el favorito para evitar duplicados
        if (!$user->isBookInFavorites($editionBookId)) {
            $user->favorites()->attach($editionBookId);
        }

        return response()->json(['success' => true]);
    }

    public function removeFromFavorites(Request $request, $editionBookId)
    {
        $user = User::find(auth()->user()->id);
        $user->favorites()->detach($editionBookId);

        return response()->json(['success' => true]);
    }
}
