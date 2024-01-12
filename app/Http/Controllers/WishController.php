<?php

namespace App\Http\Controllers;

use App\Models\Wish;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class WishController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Obtener el ID del libro desde la solicitud
            $bookId = $request->input('id');

            // Verificar si el usuario está autenticado
            if (Auth::check()) {
                // Obtener el ID del usuario autenticado
                $userId = Auth::user()->id;

                // Verificar si ya existe un deseo para este usuario y libro
                $existingWish = Wish::where('user_id', $userId)
                    ->where('book_id', $bookId)
                    ->first();

                if (!$existingWish) {
                    // Si no existe, crear un nuevo deseo
                    $wish = new Wish();
                    $wish->user_id = $userId;
                    $wish->book_id = $bookId;
                    $wish->save();

                    return redirect()->back()->with('success', 'Libro añadido a la lista de deseos.');
                } else {
                    return redirect()->back()->with('info', 'Este libro ya está en tu lista de deseos.');
                }
            } else {
                // Redirigir al inicio de sesión si el usuario no está autenticado
                return redirect()->route('login')->with('info', 'Inicia sesión para añadir libros a tu lista de deseos.');
            }
        } catch (\Exception $e) {
            // Manejar cualquier excepción
            return redirect()->back()->with('error', 'Se produjo un error al procesar la solicitud.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        try {
            // Verificar si el usuario está autenticado
            if (Auth::check()) {
                // Obtener el usuario autenticado
                $user = Auth::user();

                // Obtener la lista de deseos del usuario con la información adicional del libro
                $wishes = $user->wishes;

                return view('layouts/user/wishes/wishesList', compact('wishes'));
            } else {
                // Redirigir al inicio de sesión si el usuario no está autenticado
                return redirect()->route('login')->with('info', 'Inicia sesión para ver tu lista de deseos.');
            }
        } catch (\Exception $e) {
            // Manejar cualquier excepción
            return redirect()->back()->with('error', 'Se produjo un error al procesar la solicitud.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Wish $wish)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Wish $wish)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Obtener el usuario autenticado
            $user = Auth::user();

            // Obtener el deseo correspondiente al libro y usuario
            $wish = $user->wishes->where('book_id', $id)->first();

            // Verificar si el deseo existe y pertenece al usuario
            if ($wish) {
                $wish->delete();
                return redirect()->back()->with('success', 'Libro eliminado de la lista de deseos.');
            } else {
                return redirect()->back()->with('error', 'No se pudo encontrar el libro en tu lista de deseos.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Se produjo un error al procesar la solicitud.');
        }
    }
}
