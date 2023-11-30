<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
            'document' => 'required|mimes:pdf|max:2048',
        ]);


        // Subir la imagen de la portada
        if ($request->hasFile('cover')) {
            $image = $request->file('cover');
            $imageName = Str::slug($request->input('title')) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/editionCovers'), $imageName);
        }

        // Subir el documento PDF
        if ($request->hasFile('document')) {
            $pdfFile = $request->file('document');
            $pdfFileName = Str::slug($request->input('title')) . '_document.' . $pdfFile->getClientOriginalExtension();
            $pdfFile->move(public_path('assets/editions'), $pdfFileName);
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
            'cover' => $imageName ?? null,
            'document' => $pdfFileName ?? null,
        ]);

        return redirect()->route('editions.list')->with('success', 'La edición se ha creado correctamente.');
    }

    public function edit($id)
    {
        $edition = Edition::findOrFail($id);
        $books = Book::all();
        $languages = Language::all();
        $genres = Genre::all();
        return view('admin.management.books&editions.editions.editionEdit', compact('edition', 'books', 'languages', 'genres'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'isbn' => 'required|unique:editions,isbn,' . $id,
            'title' => 'required',
            'editorial' => 'required',
            'publication_date' => 'date',
            'language_id' => 'required|exists:languages,id',
            'price' => 'required|numeric',
            'description' => '',
            'cover' => 'image|mimes:jpeg,png,jpg|max:2048',
            'document' => 'nullable|mimes:pdf|max:2048', // Validación para el documento PDF
        ]);

        $edition = Edition::findOrFail($id);
        $imageName = $edition->cover;
        $pdfFileName = $edition->document;

        // Actualizar la imagen de la portada si se proporciona
        if ($request->hasFile('cover')) {
            // Eliminar la imagen de portada existente si la hay
            if ($imageName) {
                unlink(public_path('assets/images/editionCovers/' . $imageName));
            }

            $image = $request->file('cover');
            $imageName = Str::slug($request->input('title')) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/editionCovers'), $imageName);
        }

        // Actualizar el documento PDF
        if ($request->hasFile('document')) {
            // Eliminar el documento PDF existente si lo hay
            if ($pdfFileName) {
                unlink(public_path('assets/editions/' . $pdfFileName));
            }

            $pdfFile = $request->file('document');
            $pdfFileName = Str::slug($request->input('title')) . '_document.' . $pdfFile->getClientOriginalExtension();
            $pdfFile->move(public_path('assets/editions'), $pdfFileName);
        }

        // Actualizar la edición
        $edition->update([
            'isbn' => $request->input('isbn'),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'editorial' => $request->input('editorial'),
            'publication_date' => $request->input('publication_date'),
            'price' => $request->input('price'),
            'book_id' => $request->input('book_id'),
            'language_id' => $request->input('language_id'),
            'cover' => $imageName,
            'document' => $pdfFileName,
        ]);

        return redirect()->route('editions.list')->with('success', 'La edición se ha actualizado correctamente.');
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

    public function editionsForBook(Book $book)
    {
        $editions = $book->editions;
        return view('components.editions.forBook', compact('book', 'editions'));
    }
}
