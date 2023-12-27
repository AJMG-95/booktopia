<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wish;
use App\Models\Edition;

class WishController extends Controller
{


    /**
     * Mostrar la lista de ediciones deseadas por el usuario.
     *
     * @return \Illuminate\Http\Response
     */
    public function showWishlist()
    {
        // Obtener el ID del usuario actual
        $userId = Auth::id();

        // Obtener la lista de ediciones deseadas por el usuario
        $wishlist = Wish::where('user_id', $userId)->with('edition')->get();

        return view('layouts.user.wishes.wishesList', compact('wishlist'));
    }

   /**
     * Agregar una edición a la lista de deseos.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function add($id)
    {
        $userId = Auth::id();

        $wish = Wish::where('edition_id', $id)->where('user_id', $userId)->first();

        if (!$wish) {
            Wish::create(['edition_id' => $id, 'user_id' => $userId]);
            return redirect()->back()->with('success', 'Edición añadida a la lista de deseos');
        } else {
            return redirect()->back()->with('info', 'Esta edición ya está en tu lista de deseos');
        }
    }


    /**
     * Eliminar una edición de la lista de deseos.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function remove($id)
    {
        $userId = Auth::id();

        $wish = Wish::where('edition_id', $id)->where('user_id', $userId)->first();

        if ($wish) {
            $wish->delete();
            return redirect()->back()->with('success', 'Edición eliminada de la lista de deseos');
        }

        return redirect()->back()->with('error', 'Esta edición no estaba en tu lista de deseos');
    }


}
