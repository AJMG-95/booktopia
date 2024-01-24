<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EditionBookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\WishController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StickyNoteController;
use App\Http\Controllers\UserLibraryController;
use App\Http\Controllers\UserSubscriberController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookRatingController;
use App\Http\Controllers\BookCommentController;
use App\Http\Controllers\UserPostController;


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
                Route::patch('/update/{id}', [UserController::class, 'update'])->name('update');
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
            Route::put('/delete-account', [ProfileController::class, 'deleteAccount'])->name('profile.deleteAccount');
            Route::patch('/update-biography', [ProfileController::class, 'updateBiography'])->name('profile.update.biography');
            Route::patch('/update-as_author-biography', [ProfileController::class, 'updateAsAuthorBiography'])->name('profile.author.update.biography');

            Route::prefix('/publication')->group(function () {
                Route::get('/list', [ProfileController::class, 'autoPublicationList'])->name('profile.publication.list');
                Route::post('/create', [ProfileController::class, 'storeAutoPublicatedBook'])->name('profile.publication.create');
            });
        });


        Route::prefix('/as_author')->group(function () {
            Route::post('/register-as-author', [ProfileController::class, 'registerAsAuthor'])
                ->name('author.register');
        });

        Route::prefix('/auto_publication')->name('publications.')->group(function () {
        });


        Route::prefix('/wishes')->name('wishes.')->group(function () {
            Route::post('/add', [WishController::class, 'store'])->name('add');
            Route::delete('/remove/{id}', [WishController::class, 'destroy'])->name('remove');
            Route::get('/list', [WishController::class, 'show'])->name('list');
        });


        Route::prefix('/sticky_notes')->name('sticky_note.')->group(function () {
            Route::get('/list', [StickyNoteController::class, 'index'])->name('index');
            Route::get('/create', [StickyNoteController::class, 'create'])->name('create');
            Route::post('/store', [StickyNoteController::class, 'store'])->name('store');
            Route::get('/show/{stickyNote}', [StickyNoteController::class, 'show'])->name('show');
            Route::get('/edit/{stickyNote}', [StickyNoteController::class, 'edit'])->name('edit');
            Route::patch('/update/{stickyNote}', [StickyNoteController::class, 'update'])->name('update');
            Route::delete('/destroy/{stickyNote}', [StickyNoteController::class, 'destroy'])->name('destroy');
        });

        //* Rutas para las funcionalidades de Usuarios
        /* Ruta para listar ediciones compradas */

        Route::prefix('/library')->group(function () {
            Route::get('/', [UserLibraryController::class, 'index'])->name('user.library');
            Route::get('/search', [UserLibraryController::class, 'search'])->name('user.library.search');
            Route::get('/book/{id}', [UserLibraryController::class, 'read'])->name('user.library.read');
            Route::get('/book/detail/{id}', [UserLibraryController::class, "show"])->name('user.library.book.details');
            Route::post('/rate/book/{id}', [BookRatingController::class, 'rateBook'])->name('user.library.rate-book');
            Route::post('/comment/book/add/{id}', [BookCommentController::class, 'addComment'])->name('user.library.add-comment');
        });
    });


    Route::post('/comments/like/{commentId}', [BookCommentController::class, 'likeCommentAjax'])->name('comments.like.ajax');
    Route::post('/comments/dislike/{commentId}', [BookCommentController::class, 'dislikeCommentAjax'])->name('comments.dislike.ajax');
    Route::post('/comments/report/{commentId}', [BookCommentController::class, 'reportCommentAjax'])->name('comments.report.ajax');
    Route::delete('/comments/{commentId}', [BookCommentController::class, 'deleteComment'])->name('comments.delete');
    Route::post('/comment/add/{id}', [BookCommentController::class, 'addComment'])->name('comments.add');




    Route::get('/user_posts', [UserPostController::class, 'index'])->name('user_posts.index');
    Route::post('/user_posts/create', [UserPostController::class, 'addPost'])->name('user_posts.add');
    Route::post('/post/like/{postId}', [UserPostController::class, 'likePostAjax'])->name('post.like.ajax');
    Route::post('/post/dislike/{postId}', [UserPostController::class, 'dislikePostAjax'])->name('post.dislike.ajax');
    Route::post('/post/report/{postId}', [UserPostController::class, 'reportPostAjax'])->name('post.report.ajax');
    Route::delete('/user_posts/{postId}', [UserPostController::class, 'deletePost'])->name('user_post.delete');




    Route::prefix('/shop')->name('shop.')->group(function () {
        Route::prefix('/payment')->name('payment.')->group(function () {
            Route::post('/stripe', [PaymentController::class, 'stripe'])->name('stripe');
            Route::get('/success', [PaymentController::class, 'success'])->name('success');
            Route::get('/cancel', [PaymentController::class, 'cancel'])->name('cancel');
        });
        Route::prefix('/books')->name('books.')->group(function () {
            Route::get('/search', [EditionBookController::class, 'search'])->name('search');
        });
    });

    Route::post('/favorites/add/{editionBookId}', [FavoriteController::class, 'addFavorite'])->name('favorites.add');
    Route::post('/favorites/remove/{editionBookId}', [FavoriteController::class, 'removeFavorite'])->name('favorites.remove');


    Route::get('/subscribe', [UserSubscriberController::class, 'subscribeView'])->name('subscribe.view');
    Route::post('/subscribe/confirm', [UserSubscriberController::class, 'subscribeConfirm'])->name('subscribe.confirm');
    Route::get('/subscribe/cancel', [UserSubscriberController::class, 'subscribeCancel'])->name('subscribe.cancel');
    Route::get('/subscribe/success', [UserSubscriberController::class, 'subscribeSuccess'])->name('subscribe.success');
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

    Route::get('/book/{id}', [UserLibraryController::class, "show"])->name('details');
});

Route::prefix('/shop')->name('books.')->group(function () {
    Route::get('/', [EditionBookController::class, 'shopList'])->name('shop');
});


Auth::routes();


require __DIR__ . '/auth.php';
