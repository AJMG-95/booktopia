<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SubadminCrudController;
use App\Http\Controllers\UserCrudController;
use App\Http\Controllers\BooksAndEditionsController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\GenreController;

//*Rutas del grupo de middleware que requieren autenticación
Route::middleware(['auth'])->group(function () {




    //* Rutas para las funcionalidades del administrador
    Route::middleware(['auth', 'role:admin'])->group(function () {
        // Rutas para la administración de subadmins
        Route::prefix('admin/subadmins')->group(function () {
            Route::get('/list', [SubadminCrudController::class, 'index'])->name('subadmins.list');
            Route::get('/create', [SubadminCrudController::class, 'create'])->name('subadmins.create');
            Route::post('/store', [SubadminCrudController::class, 'store'])->name('subadmins.store');
            // Formulario de actualización de subadmins
            //* Route::get('/subadmins/edit/{id}', [SubadminCrudController::class, 'edit'])->name('subadmins.edit');
            // Lógica para actualizar subadmins (PUT o PATCH)
            //* Route::patch('/subadmins/update/{id}', [SubadminCrudController::class, 'update'])->name('subadmins.update');
            // Formulario de eliminación de subadmins
            //* Route::get('/delete/{id}', [SubadminCrudController::class, 'delete'])->name('subadmins.delete');
            Route::get('/demote/{id}', [SubadminCrudController::class, 'demoteToUser'])->name('subadmins.demote');

            Route::get('/destroy/{id}', [SubadminCrudController::class, 'destroy'])->name('subadmins.destroy');
        });
    });


    //* Rutas para las funcionalidades del administrador y Subadministradores
    Route::middleware(['auth', 'role:admin,subadmin'])->group(function () {
        /* Administración de Usuarios CRUD*/
        Route::prefix('admin/users')->group(function () {
            Route::get('/list', [UserCrudController::class, 'index'])->name('users.list');
            Route::get('/create', [UserCrudController::class, 'create'])->name('users.create');
            Route::post('/store', [UserCrudController::class, 'store'])->name('users.store');
            // Formulario de actualización de users
            //* Route::get('/edit/{id}', [UserCrudController::class, 'edit'])->name('users.edit');
            // Lógica para actualizar users (PUT o PATCH)
            //* Route::patch('/update/{id}', [UserCrudController::class, 'update'])->name('users.update');
            // Formulario de eliminación de users
            //* Route::get('/delete/{id}', [UserCrudController::class, 'delete'])->name('users.delete');
            Route::get('/promote/{id}', [UserCrudController::class, 'promoteToSubadmin'])->name('users.promote');
            Route::resource('users', UserCrudController::class)->except(['destroy']);
            Route::put('/users/destroy/{id}', [UserCrudController::class, 'destroy'])->name('users.destroy');
            Route::put('/users/toggle-block/{id}', [UserCrudController::class, 'toggleBlock'])->name('users.toggleBlock');
        });

        //Administración de libros y ediciones
        Route::prefix('admin/books&editions')->group(function () {
            Route::get('/index', [BooksAndEditionsController::class, 'index'])->name('books&editions.index');

            // CRUD DE Autores
            Route::prefix('/authors')->group(function () {
                Route::get('/list', [AuthorController::class, 'index'])->name('authors.list');
                Route::get('/create', [AuthorController::class, 'create'])->name('authors.create');
                Route::post('/store', [AuthorController::class, 'store'])->name('authors.store');
                Route::get('/edit/{id}', [AuthorController::class, 'edit'])->name('authors.edit');
                Route::put('/update/{id}', [AuthorController::class, 'update'])->name('authors.update');
                Route::get('/delete/{id}', [AuthorController::class, 'delete'])->name('authors.delete');
                Route::delete('/destroy/{id}', [AuthorController::class, 'destroy'])->name('authors.destroy');
            });

            // CRUD DE Generos
            Route::prefix('/genres')->group(function () {
                Route::get('/list', [GenreController::class, 'index'])->name('genres.list');
                Route::get('/create', [GenreController::class, 'create'])->name('genres.create');
                Route::post('/store', [GenreController::class, 'store'])->name('genres.store');
                Route::get('/edit/{id}', [GenreController::class, 'edit'])->name('genres.edit');
                Route::put('/update/{id}', [GenreController::class, 'update'])->name('genres.update');
                Route::get('/delete/{id}', [GenreController::class, 'delete'])->name('genres.delete');
                Route::delete('/destroy/{id}', [GenreController::class, 'destroy'])->name('genres.destroy');
            });

            // CRUD DE Libros
            Route::prefix('books')->group(function () {
                Route::get('/list', [BooksController::class, 'index'])->name('books.list');
                Route::get('/create', [BooksController::class, 'create'])->name('books.create');
                Route::post('/store', [BooksController::class, 'store'])->name('books.store');
                Route::get('/edit/{id}', [BooksController::class, 'edit'])->name('books.edit');
                Route::put('/update/{id}', [BooksController::class, 'update'])->name('books.update');
                Route::get('/delete/{id}', [BooksController::class, 'delete'])->name('books.delete');
                Route::put('/visibility/{id}', [BooksController::class,'toggleVisibility'])->name('books.toggleVisibility');
                Route::get('/api/authors/search', [BooksController::class, 'searchAuthors'])->name('authors.search');
                Route::delete('/books/{id}', [BooksController::class, 'destroy'])->name('books.destroy');
            });

            // CRUD DE Ediciones
            Route::prefix('editions')->group(function () {
                // Agrega rutas para ediciones aquí si es necesario
            });
        });

    });


    //* Rutas para las funcionalidades de Usuarios
    Route::middleware(['auth', 'role:user'])->group(function () {
        // Rutas para la suscripción
    });
});

Route::get('/home', [AuthController::class, "index"])->name('home');

//* Otras rutas pueden ir fuera del grupo de middleware si no requieren autenticación
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Auth::routes();
