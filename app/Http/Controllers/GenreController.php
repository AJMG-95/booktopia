<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Genre;

class GenreController extends Controller
{
    public function index()
    {
        $genres = Genre::all();
        return view('admin.management.books&editions.genres.genreList', compact('genres'));
    }


    public function create()
    {
        return view('admin.management.books&editions.genres.genreCreate');
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'genre' => [
                'required',
                'string',
                'max:255',
                Rule::unique('genres', 'genre'),
            ],
            'description' => 'nullable|string|max:1000',
            'img_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Si se ha proporcionado una imagen, procesarla
        if ($request->hasFile('img_url')) {
            $image = $request->file('img_url');
            $imageName = Str::slug($validatedData['genre']) . '.' . $image->getClientOriginalExtension();

            // Mueve la imagen al directorio público
            $image->move(public_path('assets/images/genres'), $imageName);

            $validatedData['img_url'] = $imageName;
        }

        Genre::create($validatedData);

        return redirect()->route('genres.list')->with('success', 'Género creado exitosamente.');
    }


    public function edit($id)
    {
        $genre = Genre::findOrFail($id);
        return view('admin.management.books&editions.genres.genreEdit', compact('genre'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'genre' => [
                'required',
                'string',
                'max:255',
                Rule::unique('genres', 'genre')->ignore($id), // Ignorar el género actual al verificar la unicidad del nombre
            ],
            'description' => 'nullable|string|max:1000',
            'img_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $genre = Genre::findOrFail($id);

        // Si se ha proporcionado una imagen, procesarla
        if ($request->hasFile('img_url')) {
            // Eliminar la imagen anterior
            Storage::delete('public/assets/images/genres/' . $genre->img_url);

            $image = $request->file('img_url');
            $imageName = Str::slug($validatedData['genre']) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/genres'), $imageName);
            $validatedData['img_url'] = $imageName;
        }

        $genre->update($validatedData);

        return redirect()->route('genres.list')->with('success', 'Género actualizado exitosamente.');
    }


    public function delete($id)
    {
        return view('admin.management.books&editions.genres.genreDelete', compact('id'));
    }


    public function destroy($id)
    {
        $genre = Genre::findOrFail($id);

        // Verificar si el género está asociado a algún libro
        $associatedBooks = DB::table('book_genres')->where('genre_id', $id)->exists();

        if ($associatedBooks) {
            return redirect()->route('genres.list')->with('error', 'No se puede eliminar el género porque está asociado a al menos un libro.');
        }

        // Eliminar la imagen asociada al género
        if ($genre->img_url) {
            Storage::delete('public/assets/images/genres/' . $genre->img_url);
        }

        // Eliminar el género solo si no está asociado a ningún libro
        $genre->delete();

        return redirect()->route('genres.list')->with('success', 'Género eliminado exitosamente.');
    }

    public static function randomGenres()
    {
        $randomGenres = Genre::inRandomOrder()
            ->get();

        return $randomGenres ? $randomGenres->take(10) : collect();
    }

    public function show($id)
    {
        $genre = Genre::findOrFail($id);
        return view('components.genres.genreDetail', compact('genre'));
    }


    public function booksForGenre($id)
    {
        $genre = Genre::findOrFail($id);
        $books = $genre->books;

        return view('components.book.forGenre', compact('genre', 'books'));
    }

}
