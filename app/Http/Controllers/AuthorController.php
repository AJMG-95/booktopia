<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\Country;
use App\Models\User;
use App\Models\UserAuthor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::all();
        return view('admin.management.books&editions.authors.authorList', compact('authors'));
    }

    public function create()
    {
        // Obtener la lista de países
        $countries = Country::all();

        return view('admin.management.books&editions.authors.authorCreate', compact('countries'));
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'surnames' => 'nullable|string|max:255',
            'birth_at' => 'nullable|date',
            'country_id' => 'nullable|exists:countries,id',
            'biography' => 'nullable|string|max:1000',

            // Agrega más validaciones según tus necesidades
        ]);

        // Buscar autores existentes con nombres y apellidos similares
        $existingAuthor = Author::where('name', $validatedData['name'])
            ->where('surnames', $validatedData['surnames'])
            ->first();

        // Verificar si ya existe un autor similar
        if ($existingAuthor) {
            return redirect()->route('authors.list')->with('error', 'Ya existe un autor similar.');
        }

        // Crear el autor si no hay duplicados
        Author::create($validatedData);

        return redirect()->route('authors.list')->with('success', 'Autor creado exitosamente.');
    }

    public function edit($id)
    {
        $author = Author::findOrFail($id);
        $countries = Country::all();
        return view('admin.management.books&editions.authors.authorEdit', compact('author', 'countries'));
    }

    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'surnames' => 'nullable|string|max:255',
            'birth_at' => 'nullable|date',
            'country_id' => 'nullable|exists:countries,id',
            'biography' => 'nullable|string|max:1000',
            // Agrega más validaciones según tus necesidades
        ]);

        // Buscar autores existentes con nombres y apellidos similares
        $existingAuthor = Author::where('name', $validatedData['name'])
            ->where('surnames', $validatedData['surnames'])
            ->where('id', '!=', $id) // Excluir el autor actual de la búsqueda
            ->first();

        // Verificar si ya existe un autor similar
        if ($existingAuthor) {
            return redirect()->route('authors.list')->with('error', 'Ya existe un autor similar.');
        }

        // Actualizar el autor si no hay duplicados
        $author = Author::findOrFail($id);
        $author->update($validatedData);

        return redirect()->route('authors.list')->with('success', 'Autor actualizado exitosamente.');
    }

    public function delete($id)
    {
        return view('admin.management.books&editions.authors.authorDelete', compact('id'));
    }

    public function destroy($id)
    {
        $author = Author::findOrFail($id);

        // Verificar si el autor tiene libros asociados
        if ($author->books()->exists()) {
            return redirect()->route('authors.list')->with('error', 'No se puede eliminar el autor, ya que tiene libros asociados.');
        }

        // Si no hay libros asociados, lo elimina
        $author->delete();

        return redirect()->route('authors.list')->with('success', 'Autor eliminado exitosamente.');
    }



/*     public function registerAsAuthor(Request $request)
    {
        $request->validate([
            'nickname' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'surnames' => 'required|string|max:255',
            'birth_at' => 'required|date',
            'biography' => 'required|string|max:1000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Comienza una transacción de base de datos
        DB::beginTransaction();

        try {
            // Recupera el usuario conectado
            $user = Auth::user();

            // Verifica si el usuario ya es un autor
            if ($user->author) {
                throw new \Exception('User is already registered as an author.');
            }

            // Guarda la información del autor en la base de datos
            $author = new Author([
                'nickname' => $request->input('nickname'),
                'name' => $request->input('name'),
                'surnames' => $request->input('surnames'),
                'birth_at' => $request->input('birth_at'),
                'biography' => $request->input('biography'),
                'country_id' => $user->country_id,
            ]);

            // Guarda la foto del autor si se proporciona
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('author_photos', 'public');
                $author->photo = $photoPath;
            }

            $author->save();

            // Confirma la transacción
            DB::commit();

            // Luego puedes redirigir a otra vista o realizar más acciones si es necesario

            return redirect()->route('profile.index')->with('success', 'Author registration successful.');
        } catch (\Exception $e) {
            // Si ocurre un error, revierte la transacción
            DB::rollback();
            Log::error('Author registration error: ' . $e->getMessage());

            // Maneja el error, puedes registrarlo o mostrar un mensaje de error
            return redirect('/')->with('error', $e->getMessage());
        }
    } */

    public function registerAsAuthor(Request $request)
    {
        $request->validate([
            'nickname' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'surnames' => 'required|string|max:255',
            'birth_at' => 'required|date',
            'biography' => 'required|string|max:1000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Comienza una transacción de base de datos
        DB::beginTransaction();

        try {
            // Recupera el usuario conectado
            $user = Auth::user();

            // Verifica si el usuario ya es un autor
            if ($user->author) {
                throw new \Exception('User is already registered as an author.');
            }

            // Guarda la información del autor en la base de datos
            $author = new Author([
                'nickname' => $request->input('nickname'),
                'name' => $request->input('name'),
                'surnames' => $request->input('surnames'),
                'birth_at' => $request->input('birth_at'),
                'biography' => $request->input('biography'),
                'country_id' => $user->country_id,
            ]);

            // Guarda la foto del autor si se proporciona
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('author_photos', 'public');
                $author->photo = $photoPath;
            }

            $author->save();

            // Asocia al autor con el usuario actual
            $userAuthor = new UserAuthor([
                'user_id' => $user->id,
                'author_id' => $author->id,
            ]);

            $userAuthor->save();

            // Confirma la transacción
            DB::commit();

            // Luego puedes redirigir a otra vista o realizar más acciones si es necesario

            return redirect()->route('profile.index')->with('success', 'Author registration successful.');
        } catch (\Exception $e) {
            // Si ocurre un error, revierte la transacción
            DB::rollback();
            Log::error('Author registration error: ' . $e->getMessage());

            // Maneja el error, puedes registrarlo o mostrar un mensaje de error
            return redirect('/')->with('error', $e->getMessage());
        }
    }
}
