<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Muestra la información del usuario autenticado.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $user = auth()->user();
        $editing = false; // Puedes cambiar esto según tus necesidades, dependiendo de si estás en modo de edición o no.
        $field = ''; // Define el campo que corresponda a la vista actual
        return view('layouts.user.profile.profile', compact('user', 'editing', 'field'));
    }

    /**
     * Actualiza el campo específico del usuario en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'field' => 'required|string|in:name,surnames,email,nickname,biography,country,profile_img',
            'value' => 'required',
        ]);

        // Validar y actualizar el campo específico
        $field = $request->field;
        $value = $request->value;

        if ($field === 'email') {
            $request->validate([
                'value' => 'email|unique:users,email,' . $user->id,
            ]);
        }

        User::where('id', $user->id)->update([$field => $value]);

        return redirect()->route('user.show')->with('success', ucfirst($field) . ' actualizado con éxito');
    }
}
