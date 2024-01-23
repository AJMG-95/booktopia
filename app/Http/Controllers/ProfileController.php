<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Favorite;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Wish;
use App\Models\Author;
use App\Models\User;
use App\Models\Language;
use App\Models\Genre;
use App\Models\EditionBook;

use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;


use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $languages = Language::all();
        $genres = Genre::all();

        // Obtener deseos del usuario con las ediciones asociadas
        $wishlistBooks = Wish::with('book')->where('user_id', $user->id)->get();
        $favoritesBooks = Favorite::with('book')->where('user_id', $user->id)->get();

        if ($user->isAuthor) {
            $authorForUserId = $user->user_as_author_id;
            $author = Author::findOrFail($authorForUserId);
            return view('profile.profileIndex', compact('wishlistBooks', 'favoritesBooks', 'author', 'languages', 'genres'));
        } else {
            return view('profile.profileIndex', compact('wishlistBooks', 'favoritesBooks'));
        }
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


    public function showAuthorRegistrationForm()
    {
        return view('layouts.user.asAuthor.register');
    }


    /**
     * Procesar el formulario de registro como autor.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function registerAsAuthor(Request $request)
    {
        // Validar los datos del formulario según tus necesidades
        $validatedData = $request->validate([
            'nickname' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'surnames' => 'nullable|string|max:255',
            'birth_at' => 'nullable|date',
            'country_id' => 'nullable|exists:countries,id',
            'biography' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


          // Obtén el nombre del autor
          $authorName = $validatedData['nickname'];

          // Construye el nombre único para la imagen
          $imageName = strtolower(str_replace(' ', '_', $authorName));

        // Subir la foto y obtener la ruta del archivo
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->storeAs('authors_photos', $imageName, 'public');
            $validatedData['photo'] = $photoPath;
        }

        // Crear un nuevo autor con la información proporcionada
        $author = Author::create([
            'nickname' => $request->input('nickname'),
            'name' => $request->input('name'),
            'surnames' => $request->input('surnames'),
            'birth_at' => $request->input('birth_at'),
            'country_id' => Auth::user()->country_id,
            'biography' => $request->input('biography'),
        ]);

        $userId = Auth::user()->id;
        $user = User::findOrFail($userId);
        $user->update([
            'user_as_author_id' => $author->id,
            'isAuthor' => true,
        ]);

        return redirect()->route('profile.index')->with('success', 'Te has registrado con éxito como autor.');
    }

    /**
     * Eliminar la cuenta de usuario.
     */
    public function deleteAccount(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        $user = $request->user();
        $id = $user->id;

        // Verificar si la contraseña proporcionada es correcta
        if (Hash::check($request->password, $user->password)) {
            DB::beginTransaction();

            try {
                // Cerrar la sesión y redirigir a la página de inicio
                Auth::logout();

                // Actualizar los datos del usuario
                $user = User::findOrFail($id);
                $user->update([
                    'nickname' => null,
                    'email' => null,
                    'password' => null,
                    'birth_date' => null,
                    'country_id' => null,
                    'profile_img' => null,
                    'rol_id' => null,
                    'strikes' => null,
                    'blocked' => true,
                    'deleted' => true,
                ]);

                // Confirmar la transacción
                DB::commit();

                return redirect()->route('welcome')->with('success', 'Usuario eliminado exitosamente.');
            } catch (\Exception $e) {
                // Manejar el error según tus necesidades (por ejemplo, mostrar un mensaje de error)
                DB::rollBack();
                return back()->with('error', 'Error al eliminar la cuenta. Por favor, inténtalo de nuevo.');
            }
        } else {
            return back()->withErrors(['password' => 'La contraseña proporcionada es incorrecta.'])->withInput();
        }
    }


    /**
     * Update the user's biography.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateBiography(Request $request)
    {
        try {

            $user = Auth::user();

            if ($user instanceof \App\Models\User) {
                $user->update([
                    'biography' => $request->input('biography'),
                ]);

                return redirect()->route('profile.index')->with('success', 'Biography updated successfully');
            } else {
                return redirect()->route('profile.index')->with('error', 'User variable is not an instance of User model.');
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('profile.index')->with('error', 'User not found.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('profile.index')->with('error', 'Failed to update biography. ' . $e->getMessage());
        }
    }

    public function updateAsAuthorBiography(Request $request)
    {
        try {

            $userAuthorId = Auth::user()->user_as_author_id;
            $author = Author::findOrFail($userAuthorId);

            if ($author instanceof \App\Models\Author) {
                $author->update([
                    'biography' => $request->input('biography'),
                ]);

                return redirect()->route('profile.index')->with('success', 'Biography updated successfully');
            } else {
                return redirect()->route('profile.index')->with('error', 'User variable is not an instance of Author model.');
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('profile.index')->with('error', 'User not found.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('profile.index')->with('error', 'Failed to update biography. ' . $e->getMessage());
        }
    }

    public function updateAsAuthornicknme(Request $request, $id)
    {
        try {

            $author = Author::findOrFail($id);

            $request->validate([
                'nickname' => [
                    'required',
                    'string'
                ],
            ]);

            $author->update([
                'nickname' => $request->input('nickname'),
            ]);

            return redirect()->route('profile.index')->with('success', 'Nickname updated successfully');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('profile.index')->with('error', 'User not found.');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('profile.index')->with('error', 'Failed to update nickname. ' . $e->getMessage());
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function storeAutoPublicatedBook(Request $request)
    {
        try {
            $request->validate([
                'for_adults' => 'boolean',
                'visible' => 'boolean',
                'title' => 'nullable|string|max:255',
                'cover' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'document' => 'file|mimes:pdf|max:2048',
                'language_id' => 'nullable|exists:languages,id',
                'short_description' => 'nullable|string',
                'description' => 'nullable|string',
                'authors' => 'string',
                'genres' => 'array',
                // Agrega cualquier otra regla de validación según tus necesidades
            ]);

            $data = $request->all();

            // Verifica si el checkbox "Visible" está marcado y establece el valor correspondiente
            $data['visible'] = $request->has('visible') ? true : false;

            // Verifica si el libro es visible al público y establece el precio en 0.00 euros
            if ($request->input('visible')) {
                $data['price'] = 0.00;
            }
            $editionBook = new EditionBook($data);
            $editionBook->save();

            // Verifica si se proporcionó un archivo PDF
            if ($request->hasFile('document')) {
                $documentFile = $request->file('document');
                $documentFileName = $editionBook->id . '.pdf';  // Nombre basado en el ID del libro
                $documentPath = $documentFile->storeAs('documents', $documentFileName, 'public');
                $editionBook->document = $documentPath;
            }

            // Verifica si se proporcionó una portada
            if ($request->hasFile('cover')) {
                $coverFile = $request->file('cover');
                $coverFileName = $editionBook->id . '.' . $coverFile->getClientOriginalExtension();
                $coverPath = $coverFile->storeAs('covers', $coverFileName, 'public');
                $editionBook->cover = $coverPath;
                $editionBook->save();  // Guarda el modelo actualizado con la ruta de la portada
            }

            // Asocia los autores
            if ($request->has('authors')) {
                $editionBook->authors()->attach($request->input('authors'));
            }

            // Asocia los géneros
            if ($request->has('genres')) {
                $editionBook->genres()->attach($request->input('genres'));
            }

            return redirect()->route('profile.index')->with('success', 'Libro creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('profile.index')->with('error', 'Error al crear el libro.');
        }
    }

    public function autoPublicationList()
    {
        // Obtener el ID del autor del usuario conectado
        $authorId = Auth::user()->user_as_author_id;
        $author = Author::findOrFail($authorId);
        $languages = Language::all();
        $genres = Genre::all();


        // Obtener todos los libros asociados al ID del autor
        $books = EditionBook::whereHas('authors', function ($query) use ($authorId) {
            $query->where('author_id', $authorId);
        })->get();

        // Puedes ajustar el nombre de la vista según tu estructura de carpetas
        return view('layouts/user/asAuthor/publications/index', compact('books', 'author', 'genres', 'languages'));
    }
}
