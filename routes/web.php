<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EditionBookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\EditionsShopController;
use App\Http\Controllers\WishController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserStickyNoteController;
use App\Http\Controllers\ProfileController;

//!Rutas del grupo de middleware que requieren autenticación
Route::get('/home', [AuthController::class, "index"])->name('home');

Route::middleware(['auth'])->group(function () {

    //* Rutas para las funcionalidades del administrador
    Route::prefix('admin/subadmins')->group(function () {
        Route::get('/list', [UserController::class, 'subadminList'])->name('subadmins.list');
        Route::get('/create', [UserController::class, 'create'])->name('subadmins.create');
        Route::post('/', [UserController::class, 'store'])->name('subadmins.store');
        Route::get('/{id}', [UserController::class, 'show'])->name('subadmins.show');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('subadmins.edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('subadmins.update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('subadmins.destroy');
    });

    //* Rutas para las funcionalidades del administrador y Subadministradores
    Route::middleware(['auth', 'role:admin,subadmin'])->group(function () {

        Route::prefix('management')->group(function () {

            Route::prefix('/users')->name('user.')->group(function () {
                Route::get('/list', [UserController::class, 'List'])->name('list');
                Route::get('/create', [UserController::class, 'create'])->name('create');
                Route::post('/store', [UserController::class, 'store'])->name('store');
                Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
                Route::put('/update/{id}', [UserController::class, 'update'])->name('update');
                Route::get('/delete/{id}', [UserController::class, 'delete'])->name('delete');
                Route::delete('/destroy/{id}', [UserController::class, 'destroy'])->name('destroy');
                Route::put('/promote-to-subadmin/{id}', [UserController::class, 'promoteToSubadmin'])->name('promoteToSubadmin');
                Route::put('/toggle-block/{id}', [UserController::class, 'toggleBlock'])->name('toggleBlock');
            });

            Route::get('/books/management', function () {
                return view('admin.management.management_index');
            })->name('books.management');

            // CRUD DE Autores
            Route::prefix('/authors')->group(function () {
                Route::get('/list', [AuthorController::class, 'index'])->name('authors.list');
                Route::get('/create', [AuthorController::class, 'create'])->name('authors.create');
                Route::post('/store', [AuthorController::class, 'store'])->name('authors.store');
                Route::get('/edit/{id}', [AuthorController::class, 'edit'])->name('authors.edit');
                Route::patch('/update/{id}', [AuthorController::class, 'update'])->name('authors.update');
                Route::get('/delete/{id}', [AuthorController::class, 'delete'])->name('authors.delete');
                Route::delete('/destroy/{id}', [AuthorController::class, 'destroy'])->name('authors.destroy');
            });

            // CRUD DE Generos
            Route::prefix('/genres')->group(function () {
                Route::get('/list', [GenreController::class, 'list'])->name('genres.list');
                Route::get('/create', [GenreController::class, 'create'])->name('genres.create');
                Route::post('/store', [GenreController::class, 'store'])->name('genres.store');
                Route::get('/edit/{id}', [GenreController::class, 'edit'])->name('genres.edit');
                Route::patch('/update/{id}', [GenreController::class, 'update'])->name('genres.update');
                Route::get('/delete/{id}', [GenreController::class, 'delete'])->name('genres.delete');
                Route::delete('/destroy/{id}', [GenreController::class, 'destroy'])->name('genres.destroy');

            });


            // CRUD DE Libros/Ediciones
            Route::prefix('books')->name('books.')->group(function () {
                Route::get('/list', [EditionBookController::class, 'list'])->name('list');
                Route::get('/create', [EditionBookController::class, 'create'])->name('create');
                Route::post('/store', [EditionBookController::class, 'store'])->name('store');
                Route::get('/show/{editionBook}', [EditionBookController::class, 'show'])->name('show');
                Route::get('/edit/{editionBook}', [EditionBookController::class, 'edit'])->name('edit');
                Route::patch('/update/{editionBook}', [EditionBookController::class, 'update'])->name('update');
                Route::delete('/destroy/{editionBook}', [EditionBookController::class, 'destroy'])->name('destroy');
                Route::post('/visibility/{editionBook}', [EditionBookController::class, 'toggleVisibility'])->name('toggleVisibility');

            });
        });
    });


    Route::prefix('/user')->group(function () {
        Route::prefix('/profile')->group(function () {
            Route::get('/index', [ProfileController::class, 'index'])->name('profile.index');
            Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/update', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/destroy', [ProfileController::class, 'destroy'])->name('profile.destroy');
        });

        Route::prefix('/as_author')->group(function () {
            Route::get('/register', [ProfileController::class, 'showAuthorRegistrationForm'])->name('author.register.form');
            Route::post('/store', [AuthorController::class, 'registerAsAuthor'])->name('author.register');
        });

        Route::prefix('/auto_publication')->name('publications.')->group(function () {

        });


        Route::prefix('/wishes')->name('wishes.')->group(function () {
            Route::post('/add/{id}', [WishController::class, 'add'])->name('add');
            Route::delete('/remove/{id}', [WishController::class, 'remove'])->name('remove');
            Route::get('/list', [WishController::class, 'showWishlist'])->name('list');
        });


        Route::prefix('/sticky_notes')->name('sticky_note.')->group(function () {
            Route::get('/list', [UserStickyNoteController::class, 'index'])->name('index');
            Route::get('/create', [UserStickyNoteController::class, 'create'])->name('create');
            Route::post('/store', [UserStickyNoteController::class, 'store'])->name('store');
            Route::get('/show/{stickyNote}', [UserStickyNoteController::class, 'show'])->name('show');
            Route::get('/edit/{stickyNote}', [UserStickyNoteController::class, 'edit'])->name('edit');
            Route::put('/update/{stickyNote}', [UserStickyNoteController::class, 'update'])->name('update');
            Route::delete('/destroy/{stickyNote}', [UserStickyNoteController::class, 'destroy'])->name('destroy');

        });

        //* Rutas para las funcionalidades de Usuarios
        /* Ruta para listar ediciones compradas */

    });

    Route::prefix('/shop')->name('shop.')->group(function () {
        Route::prefix('/payment')->name('payment.')->group(function () {
            Route::post('/stripe', [PaymentController::class, 'stripe'])->name('stripe');
            Route::get('/success', [PaymentController::class, 'success'])->name('success');
            Route::get('/cancel', [PaymentController::class, 'cancel'])->name('cancel');
        });

    });


});


//! Otras rutas que no requieren autenticación
Route::get('/', function () {
    $randomBooks = app(EditionBookController::class)->randomBooks();
    $randomGenres = app(GenreController::class)->randomGenres();

    return view('welcome', compact('randomBooks', 'randomGenres'));
})->name('welcome');


Route::prefix('/genre')->name('genre.')->group(function () {
    Route::get('/{id}', [GenreController::class, "show"])->name('show');
});


Route::prefix('/books')->name('books.')->group(function () {
    Route::get('/of_genre/{genre}', [GenreController::class, 'booksForGenre'])->name('forGenre');
    Route::get('/book/{id}', [EditionBookController::class, "show"])->name('show');
});

Route::prefix('/shop')->name('books.')->group(function () {
    Route::get('/', [EditionBookController::class, 'shopList'])->name('shop');
});


Auth::routes();


require __DIR__ . '/auth.php';
