<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Edition;
use App\Models\Book;
use App\Models\Language;
use App\Models\Genre;
use App\Models\User;
use App\Models\Invoice;
use App\Models\MyLibrary;

class EditionsController extends Controller
{
    public function index()
    {
        $editions = Edition::all();
        return view('admin.management.books&editions.editions.editionList', compact('editions'));
    }

    public function create()
    {
        $books = Book::all();
        $languages = Language::all();
        $genres = Genre::all();
        return view('admin.management.books&editions.editions.editionCreate', compact('books', 'languages', 'genres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'isbn' => 'required|unique:editions,isbn',
            'title' => 'required',
            'editorial' => 'required',
            'publication_date' => 'date',
            'language_id' => 'required|exists:languages,id',
            'price' => 'required|numeric',
            'description' => '',
            'cover' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Subir la imagen de la portada
        if ($request->hasFile('cover')) {
            $image = $request->file('cover');
            $imageName = Str::slug($request->input('original_title')) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/bookCovers'), $imageName);
            $validatedData['cover'] = $imageName;
            $book->cover = $imageName;
        }

        // Crear la edición
        $edition = Edition::create([
            'book_id' => $request->input('book_id'),
            'isbn' => $request->input('isbn'),
            'title' => $request->input('title'),
            'editorial' => $request->input('editorial'),
            'publication_date' => $request->input('publication_date'),
            'language_id' => $request->input('language_id'),
            'price' => $request->input('price'),
            'description' => $request->input('description'),
            'cover' => $coverFileName,
        ]);

        return redirect()->route('editions.list')->with('success', 'La edición se ha creado correctamente.');
    }

    public function edit($id)
    {
        $edition = Edition::findOrFail($id);
        $books = Book::all();
        $languages = Language::all();
        $genres = Genre::all();
        return view('editions.edit', compact('edition', 'books', 'languages', 'genres'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            // Agrega las reglas de validación según tus requisitos
        ]);

        $edition = Edition::findOrFail($id);
        // Lógica para actualizar una edición
        // ...

        return redirect()->route('editions.index')->with('success', 'Edición actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $edition = Edition::findOrFail($id);

        // Verificar si hay referencias en my_libraries
        $libraryReferences = MyLibrary::where('edition_id', $id)->exists();

        // Verificar si hay referencias en edition_invoices
        $invoiceReferences = $edition->invoices()->exists();

        if (!$libraryReferences && !$invoiceReferences) {
            $edition->delete();
            return redirect()->route('editions.list')->with('success', 'La edicion se ha eliminado correctamente.');
        }

        if (!$libraryReferences && $invoiceReferences) {
            $edition->update([
                'description' => null,
                'cover' => null,
                'url' => null,
                'deleted' => true,
            ]);

            return redirect()->route('editions.list')->with('error', 'La edición ha sufrido un borrado parcial');
        }

        if ($libraryReferences) {
            return redirect()->route('editions.list')->with('error', 'La edición no puede ser eliminada, pero se actualizó.');
        }
    }
}
