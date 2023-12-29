<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use App\Models\Edition;
use App\Models\Author;
use App\Models\Genre;
use App\Models\Language;
use App\Models\Payment;

class EditionsBuyedController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Validación de entrada
            $request->validate([
                'title' => 'nullable|string|max:255',
                'author' => 'nullable|string|max:255',
                'genre' => 'nullable|string|max:255',
                'max_price' => 'nullable|numeric|min:0',
                'min_price' => 'nullable|numeric|min:0',
                'sortBy' => 'nullable|in:asc_price,desc_price,asc_title,desc_title,publication_date',
            ]);

            // Obtén el usuario autenticado
            $user = auth()->user();

            // Obtener las ediciones compradas por el usuario
            $purchasedEditions = Payment::with('edition.book.authors', 'edition.book.genres')
                ->where('user_id', $user->id)
                ->where('payment_status', 'complete')
                ->when($request->filled('title'), function ($query) use ($request) {
                    $query->where('edition_name', 'ilike', '%' . strtolower($request->input('title')) . '%');
                })
                ->when($request->filled('author'), function ($query) use ($request) {
                    $query->whereHas('edition.book.authors', function ($q) use ($request) {
                        $q->whereRaw('LOWER(name) like ?', ['%' . strtolower($request->input('author')) . '%']);
                    });
                })
                ->when($request->filled('genre'), function ($query) use ($request) {
                    $query->whereHas('edition.book.genres', function ($q) use ($request) {
                        $q->whereRaw('LOWER(genre) like ?', ['%' . strtolower($request->input('genre')) . '%']);
                    });
                })
                ->when($request->filled('max_price'), function ($query) use ($request) {
                    $query->where('amount', '<=', $request->input('max_price'));
                })
                ->when($request->filled('min_price'), function ($query) use ($request) {
                    $query->where('amount', '>=', $request->input('min_price'));
                })
                ->when($request->filled('sortBy'), function ($query) use ($request) {
                    switch ($request->input('sortBy')) {
                        case 'asc_price':
                            $query->orderBy('amount', 'asc');
                            break;
                        case 'desc_price':
                            $query->orderBy('amount', 'desc');
                            break;
                        case 'asc_title':
                            $query->orderBy('edition_name', 'asc');
                            break;
                        case 'desc_title':
                            $query->orderBy('edition_name', 'desc');
                            break;
                        case 'publication_date':
                            $query->orderBy('created_at', 'desc');
                            break;
                    }
                })
                ->paginate(10);

            // También puedes cargar información adicional si es necesario
            $genres = Genre::all();
            $languages = Language::all();
            $authors = Author::all();

            // Pasar los datos a la vista
            return view('layouts.user.editions.buyedEditions', compact('purchasedEditions', 'genres', 'languages', 'authors', 'request'));
        } catch (ValidationException $validationException) {
            // Manejar errores de validación
            return redirect()->back()->withErrors($validationException->errors());
        } catch (QueryException $queryException) {
            // Manejar errores de consulta de base de datos
            Log::error('Error de consulta: ' . $queryException->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error al procesar la solicitud. Por favor, intenta de nuevo.');
        } catch (\Exception $exception) {
            // Manejar otras excepciones no capturadas
            Log::error('Error inesperado: ' . $exception->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error inesperado. Por favor, intenta de nuevo.');
        }
    }

    public function show($editionId)
    {
        $edition = Edition::find($editionId);

        if (!$edition) {
            abort(404, 'Edición no encontrada');
        }

        $filename = $edition->document;

        $path = public_path('assets/editions/' . $filename);

        if (!File::exists($path)) {
            abort(404, 'Archivo no encontrado');
        }

        $headers = [
            'Content-Type' => 'application/pdf',
        ];

        return response()->file($path, $headers);
    }
}
