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
        return view('layouts.user.profile.profile', compact('user'));
    }


    /**
     * Muestra el formulario para editar el nombre del usuario.
     *
     * @return \Illuminate\View\View
     */
    public function editName()
    {
        $user = auth()->user();
        return view('user.edit-name', compact('user'));
    }

    /**
     * Actualiza el nombre del usuario en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateName(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        User::where('id', $user->id)->update(['name' => $request->name]);


        return redirect()->route('user.show')->with('success', 'Nombre actualizado con éxito');
    }

    /**
     * Muestra el formulario para editar los apellidos del usuario.
     *
     * @return \Illuminate\View\View
     */
    public function editSurnames()
    {
        $user = auth()->user();
        return view('user.edit-surnames', compact('user'));
    }

    /**
     * Actualiza los apellidos del usuario en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSurnames(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'surnames' => 'required|string|max:255',
        ]);

        User::where('id', $user->id)->update(['surnames' => $request->surnames]);

        return redirect()->route('user.show')->with('success', 'Apellidos actualizados con éxito');
    }

    /**
     * Muestra el formulario para editar el correo electrónico del usuario.
     *
     * @return \Illuminate\View\View
     */
    public function editEmail()
    {
        $user = auth()->user();
        return view('user.edit-email', compact('user'));
    }

    /**
     * Actualiza el correo electrónico del usuario en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateEmail(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $existingUser = User::where('email', $request->email)->first();

        if ($existingUser && $existingUser->id !== $user->id) {
            return redirect()->route('user.show')->with('error', 'Ya existe una cuenta con ese correo electrónico.');
        }

        User::where('id', $user->id)->update(['email' => $request->email]);

        return redirect()->route('user.show')->with('success', 'Correo electrónico actualizado con éxito');
    }


    /**
     * Muestra el formulario para editar la contraseña del usuario.
     *
     * @return \Illuminate\View\View
     */
    public function editPassword()
    {
        $user = auth()->user();
        return view('user.edit-password', compact('user'));
    }

    /**
     * Actualiza la contraseña del usuario en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::where('id', $user->id)->update(['password' => Hash::make($request->password)]);

        return redirect()->route('user.show')->with('success', 'Contraseña actualizada con éxito');
    }

    /**
     * Muestra el formulario para editar la imagen de perfil del usuario.
     *
     * @return \Illuminate\View\View
     */
    public function editProfileImage()
    {
        $user = auth()->user();
        return view('user.edit-profile-image', compact('user'));
    }

    /**
     * Actualiza la imagen de perfil del usuario en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfileImage(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'profile_img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('profile_img')) {
            $profileImage = $request->file('profile_img');
            $imageName = time() . '.' . $profileImage->getClientOriginalExtension();
            $profileImage->move(public_path('images/profile'), $imageName);
            User::where('id', $user->id)->update(['profile_img' => $imageName]);
        }

        return redirect()->route('user.show')->with('success', 'Imagen de perfil actualizada con éxito');
    }
}
