<?php

namespace App\Http\Controllers;

use App\Models\Edition;
use App\Models\Book;
use App\Models\Language;
use Illuminate\Http\Request;

class EditionController extends Controller
{
    public function index()
    {
        $editions = Edition::with('book', 'language')->get();

        return view('edition.index', compact('editions'));
    }

    public function create()
    {
        $books = Book::all();
        $languages = Language::all();

        return view('edition.create', compact('books', 'languages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'isbn' => 'nullable|string',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'cover' => 'nullable|string',
            'editorial' => 'nullable|string',
            'publication_date' => 'nullable|date',
            'price' => 'required|numeric',
            'url' => 'nullable|string',
            'book_id' => 'required|exists:books,id',
            'language_id' => 'required|exists:languages,id',
        ]);

        $edition = new Edition($request->only(['isbn', 'title', 'description', 'cover', 'editorial', 'publication_date', 'price', 'url']));
        $edition->save();

        $edition->book()->associate($request->input('book_id'));
        $edition->language()->associate($request->input('language_id'));
        $edition->save();

        return redirect()->route('edition.index')->with('success', 'Edition created successfully.');
    }

    public function show($id)
    {
        $edition = Edition::with('book', 'language')->findOrFail($id);

        return view('edition.show', compact('edition'));
    }

    public function edit($id)
    {
        $edition = Edition::with('book', 'language')->findOrFail($id);
        $books = Book::all();
        $languages = Language::all();

        return view('edition.edit', compact('edition', 'books', 'languages'));
    }

    public function update(Request $request, $id)
    {
        $edition = Edition::findOrFail($id);

        $request->validate([
            'isbn' => 'nullable|string',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'cover' => 'nullable|string',
            'editorial' => 'nullable|string',
            'publication_date' => 'nullable|date',
            'price' => 'required|numeric',
            'url' => 'nullable|string',
            'book_id' => 'required|exists:books,id',
            'language_id' => 'required|exists:languages,id',
        ]);

        $edition->fill($request->only(['isbn', 'title', 'description', 'cover', 'editorial', 'publication_date', 'price', 'url']));
        $edition->book()->associate($request->input('book_id'));
        $edition->language()->associate($request->input('language_id'));
        $edition->save();

        return redirect()->route('edition.index')->with('success', 'Edition updated successfully.');
    }

    public function destroy($id)
    {
        $edition = Edition::findOrFail($id);
        $edition->delete();

        return redirect()->route('edition.index')->with('success', 'Edition deleted successfully.');
    }
}
