<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Genre;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('authors', 'genres')->get();

        return view('book.index', compact('books'));
    }

    public function create()
    {
        $authors = Author::all();
        $genres = Genre::all();

        return view('book.create', compact('authors', 'genres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'original_title' => 'required|string|max:255',
            'self_published' => 'nullable|boolean',
            'cover' => 'nullable|string',
            'visible' => 'nullable|boolean',
            'author_ids' => 'required|array',
            'author_ids.*' => 'exists:authors,id',
            'genre_ids' => 'required|array',
            'genre_ids.*' => 'exists:genres,id',
        ]);

        $book = new Book($request->only(['original_title', 'self_published', 'cover', 'visible']));
        $book->save();

        $book->authors()->attach($request->input('author_ids'));
        $book->genres()->attach($request->input('genre_ids'));

        return redirect()->route('book.index')->with('success', 'Book created successfully.');
    }

    public function show($id)
    {
        $book = Book::with('authors', 'genres')->findOrFail($id);

        return view('book.show', compact('book'));
    }

    public function edit($id)
    {
        $book = Book::with('authors', 'genres')->findOrFail($id);
        $authors = Author::all();
        $genres = Genre::all();

        return view('book.edit', compact('book', 'authors', 'genres'));
    }

    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $request->validate([
            'original_title' => 'required|string|max:255',
            'self_published' => 'nullable|boolean',
            'cover' => 'nullable|string',
            'visible' => 'nullable|boolean',
            'author_ids' => 'required|array',
            'author_ids.*' => 'exists:authors,id',
            'genre_ids' => 'required|array',
            'genre_ids.*' => 'exists:genres,id',
        ]);

        $book->fill($request->only(['original_title', 'self_published', 'cover', 'visible']));
        $book->save();

        $book->authors()->sync($request->input('author_ids'));
        $book->genres()->sync($request->input('genre_ids'));

        return redirect()->route('book.index')->with('success', 'Book updated successfully.');
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return redirect()->route('book.index')->with('success', 'Book deleted successfully.');
    }
}
