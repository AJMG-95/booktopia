<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Country;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = Author::all();
        return view('admin.management.authors.authorList', compact('authors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::all();
        return view('admin.management.authors.authorCreate', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
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
            $authorName = $validatedData['name'];

            // Construye el nombre único para la imagen
            $imageName = strtolower(str_replace(' ', '_', $authorName));

            // Subir la foto y obtener la ruta
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->storeAs('authors_photos', $imageName, 'public');
                $validatedData['photo'] = $photoPath;
            }

            $author = Author::create($validatedData);

            return redirect()->route('authors.list')->with('success', 'Autor creado exitosamente.');
        } catch (\Exception $e) {
            // Manejar la excepción
            return redirect()->back()->with('error', 'Error al crear el autor: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    /*     public function show(Author $author)
    {
        return view('admin.management.authors.show', compact('author'));
    }
 */
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        $countries = Country::all();
        return view('admin.management.authors.authorEdit', compact('author', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        try {
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
            $authorName = $validatedData['name'];

            // Construye el nombre único para la imagen
            $imageName = strtolower(str_replace(' ', '_', $authorName));

            // Subir la foto y obtener la ruta
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->storeAs('authors_photos', $imageName, 'public');
                $validatedData['photo'] = $photoPath;
            }

            $author->update($validatedData);

            return redirect()->route('authors.list')->with('success', 'Autor actualizado exitosamente.');
        } catch (\Exception $e) {
            // Manejar la excepción
            return redirect()->back()->with('error', 'Error al actualizar el autor: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {

        try {
            $author->delete();

            return redirect()->route('authors.list')->with('success', 'Autor eliminado exitosamente.');
        } catch (\Exception $e) {
            // Manejar la excepción
            return redirect()->back()->with('error', 'Error al eliminar el autor: ' . $e->getMessage());
        }
    }
}
