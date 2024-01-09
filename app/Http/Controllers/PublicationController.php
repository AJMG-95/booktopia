<?php

// app/Http/Controllers/PublicationController.php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Edition;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\UserAuthor;

class PublicationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Obtener las ediciones asociadas al usuario a través de las relaciones
        $editions = Edition::whereHas('book.authors.userAuthors', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();

        return view('layouts.user.asAuthor.publications.index', compact('editions'));
    }

    public function create()
    {
        // Obtén el usuario conectado
        $user = Auth::user();

        // Verifica si el usuario ya es un autor
        if ($user) {
            // Si no es un autor, redirige a la ruta para registrarse como autor
            return redirect()->route('author.register.form')->with('error', 'Debes registrarte como autor antes de publicar.');
        }

        // Variables para almacenar el libro y la edición
        $book = null;
        $edition = null;

        // Comienza la transacción de la base de datos
        DB::beginTransaction();

        try {
            // Crea el libro
            $bookData = [
                'self_published' => true, // Puedes cambiar esto según tus requisitos
                'original_title' => 'Nuevo Libro', // Puedes personalizarlo según tus requisitos
                'visible' => true, // Puedes cambiar esto según tus requisitos
            ];

            $book = Book::create($bookData);

            // Asocia el libro al autor
            $userAuthor = Auth::user()->author;
            $userAuthor->books()->attach($book->id);

            // Crea la edición asociada al libro
            $editionData = [
                'isbn' => 'ISBN-AUTOGENERADO', // Puedes personalizarlo o generarlo de alguna manera
                'title' => 'Nueva Edición', // Puedes personalizarlo según tus requisitos
                'editorial' => 'Editorial', // Puedes personalizarlo según tus requisitos
                'price' => 0.00, // Puedes cambiarlo según tus requisitos
                'language_id' => 1, // Puedes cambiarlo según tus requisitos
                // Otros campos según tus requisitos
            ];

            $edition = $book->editions()->create($editionData);

            // Commit de la transacción
            DB::commit();
        } catch (\Exception $e) {
            // Si hay un error, realiza un rollback de la transacción
            DB::rollback();
            // Maneja el error como prefieras (por ejemplo, logueándolo)
            return redirect()->route('profile.index')->with('error', 'Error al crear libro y edición.');
        }

        // Redirige a la vista deseada con los datos necesarios
        return view('layouts.user.asAuthor.publications.create', compact('book', 'edition'));
    }


    // Resto de los métodos del controlador
}
