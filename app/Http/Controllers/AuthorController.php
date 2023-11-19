<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\Country;

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

}
