<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Wish;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Obtener deseos del usuario con las ediciones asociadas
        $wishlistBooks = Wish::with('edition')->where('user_id', $user->id)->get();

        return view('profile.profileIndex', compact('wishlistBooks'));
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        // Comprobar el tipo de actualización
        $updateType = $request->input('update_type', 'profile');

        if ($updateType === 'password') {
            // Lógica para actualizar la contraseña
            $this->validate($request, [
                'current_password' => 'required',
                'password' => 'required|confirmed|min:8',
            ]);

            // Verificar que la contraseña actual es válida
            if (!Hash::check($request->input('current_password'), $user->password)) {
                return redirect()->back()->withErrors(['current_password' => 'La contraseña actual no es correcta.'])->withInput();
            }

            $user->password = bcrypt($request->input('password'));
        } else {
            // Lógica para actualizar el perfil
            $this->validate($request, [
                'nickname' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'profile_img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            // Guardar la imagen en la carpeta 'public'
            if ($request->hasFile('profile_img')) {
                $image = $request->file('profile_img');
                $imageName = 'profile_' . $user->id . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('assets/images/profile'), $imageName);
                $user->profile_img = $imageName;
            }
            $user->nickname = $request->input('nickname');
            $user->email = $request->input('email');
        }

        $user->save();


        // Redireccionar o realizar otras acciones después de guardar los cambios

        // Ejemplo de redirección
        return redirect()->route('profile.index')->with('success', 'Perfil actualizado con éxito.');
    }



    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
