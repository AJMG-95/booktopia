<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        try {
            $genres = Genre::all();
            return view('admin.management.genres.genreList', compact('genres'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return view('admin.management.genres.genreCreate');
        } catch (\Exception $e) {
            return redirect()->route('genres.list')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'genre_name' => 'required|unique:genres|max:255',
                'description' => 'nullable',
                'img_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image upload
            ]);

            $genre = Genre::create($validatedData);

            // Handle image upload
            if ($request->hasFile('img_url')) {
                $image = $request->file('img_url');
                $imageName = $genre->id . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/genres', $imageName);

                // Save the image URL in the database
                $genre->update(['img_url' => 'genres/' . $imageName]);
            }

            return redirect()->route('genres.list')->with('success', 'Genre created successfully');
        } catch (\Exception $e) {
            return redirect()->route('genres.list')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
/*     public function show(Genre $genre)
    {
        try {
            return view('admin.management.genres.genreShow', compact('genre'));
        } catch (\Exception $e) {
            return redirect()->route('genres.list')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    } */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $genre = Genre::findOrFail($id);
            return view('admin.management.genres.genreEdit', compact('genre'));
        } catch (\Exception $e) {
            return redirect()->route('genres.list')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $genre = Genre::findOrFail($id);
            $validatedData = $request->validate([
                'genre_name' => 'required|unique:genres,genre_name,' . $genre->id,
                'description' => 'nullable',
                'img_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image upload
            ]);

            // Handle image update
            if ($request->hasFile('img_url')) {
                $image = $request->file('img_url');
                $imageName = $genre->id . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/genres', $imageName);

                // Save the updated image URL in the database
                $validatedData['img_url'] = 'genres/' . $imageName;
            }

            $genre->update($validatedData);

            return redirect()->route('genres.list')->with('success', 'Genre updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('genres.list')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $genre = Genre::findOrFail($id);

            // Check if there are references to this genre in the book_genres table
            if ($genre->books()->count() > 0) {
                return redirect()->route('genres.list')->with('error', 'Cannot delete genre with existing references in book_genres table');
            }

            // If no references, proceed with deletion
            $genre->delete();

            return redirect()->route('genres.list')->with('success', 'Genre deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('genres.list')->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }


    public static function randomGenres()
    {
        try {
            $randomGenres = Genre::inRandomOrder()->get();
            return $randomGenres ? $randomGenres->take(10) : collect();
        } catch (\Exception $e) {
            return collect();
        }
    }
}
