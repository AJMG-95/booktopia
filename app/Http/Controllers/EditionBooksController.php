<?php

namespace App\Http\Controllers;

use App\Models\EditionBook;
use App\Models\Payment;
use Illuminate\Http\Request;

class EditionBooksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $editionBooks = EditionBook::all();
        return view('edition_books.index', compact('editionBooks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('edition_books.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'isbn' => 'nullable|string|max:255',
            'self_published' => 'boolean',
            'title' => 'nullable|string|max:255',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'cover' => 'nullable|string',
            'visible' => 'boolean',
            'editorial' => 'nullable|string',
            'price' => 'nullable|numeric|between:0,999999.99',
            'document' => 'nullable|string',
            'language_id' => 'nullable|exists:languages,id',
            // Add more validation rules as needed
        ]);

        // Create a new EditionBook instance and fill it with the validated data
        $editionBook = EditionBook::create($validatedData);

        // Redirect to the index page or show the newly created resource
        return redirect()->route('edition_books.index')->with('success', 'Edition Book created successfully!');
    }

    /**
     * Show the detailed view of the specified resource.
     */
    public function detail(EditionBook $editionBook)
    {
        return view('edition_books.detail', compact('editionBook'));
    }

    /**
     * Display a listing of all edition books.
     */
    public function list()
    {
        $editionBooks = EditionBook::all();
        return view('edition_books.list', compact('editionBooks'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EditionBook $editionBook)
    {
        return view('edition_books.edit', compact('editionBook'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EditionBook $editionBook)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'isbn' => 'nullable|string|max:255',
            'self_published' => 'boolean',
            'title' => 'nullable|string|max:255',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'cover' => 'nullable|string',
            'visible' => 'boolean',
            'editorial' => 'nullable|string',
            'price' => 'nullable|numeric',
            'document' => 'nullable|string',
            'language_id' => 'nullable|exists:languages,id',
            'deleted' => 'boolean',
            // Add more validation rules as needed
        ]);

        // Update the EditionBook instance with the validated data
        $editionBook->update($validatedData);

        // Redirect to the index page or show the updated resource
        return redirect()->route('edition_books.index')->with('success', 'Edition Book updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EditionBook $editionBook)
    {
        // Check if the EditionBook's id is present in the payments table
        $isUsedInPayments = Payment::where('edition_id', $editionBook->id)->exists();

        if ($isUsedInPayments) {
            // If the EditionBook is used in payments, show a message and don't delete it
            return redirect()->route('edition_books.index')->with('error', 'Cannot delete. Edition Book is associated with payments.');
        }

        // If not used in payments, proceed with deletion
        $editionBook->delete();

        // Redirect to the index page with a success message
        return redirect()->route('edition_books.index')->with('success', 'Edition Book deleted successfully!');
    }

    /**
     * Toggle the visibility of the specified EditionBook.
     */
    public function toggleVisibility(EditionBook $editionBook)
    {
        // Toggle the 'visible' field
        $editionBook->update(['visible' => !$editionBook->visible]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Edition Book visibility toggled successfully!');
    }
}
