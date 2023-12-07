<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wish;

class WishController extends Controller
{
    /**
     * Agregar una edición a la lista de deseos.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function add($id)
    {
        // Obtener el ID del usuario actual
        $userId = Auth::id();

        // Verificar si la edición ya está en la lista de deseos
        $wish = Wish::where('edition_id', $id)->where('user_id', $userId)->first();

        if (!$wish) {
            // Si no está en la lista de deseos, añadirlo
            Wish::create(['edition_id' => $id, 'user_id' => $userId]);
            return redirect()->back()->with('success', 'Edición añadida a la lista de deseos');
        } else {
            // Si ya está en la lista de deseos, mostrar un mensaje o redirigir a otra página
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
        // Buscar y eliminar el registro de la lista de deseos
        $wish = Wish::where('edition_id', $id)->first();

        if ($wish) {
            $wish->delete();

            // Puedes devolver una respuesta JSON, si es necesario
            return response()->json(['message' => 'Edición eliminada de la lista de deseos']);
        }

        // Devolver una respuesta JSON indicando que la edición no estaba en la lista de deseos
        return response()->json(['message' => 'La edición no estaba en la lista de deseos']);
    }



}
