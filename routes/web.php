<?php

use App\Http\Controllers\AdminUserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SubscribeController;


//*Rutas del grupo de middleware que requieren autenticación
Route::middleware(['auth'])->group(function () {


    //* Rutas para las funcionalidades del administrador
    //Route::middleware(['auth', 'role:admin'])->group(function () {
    //   /* Administración de Subadmins */
    //   Route::get('/subadmins', [UserController::class, 'showAllSubadmins'])->name('subadmins.show');
    //    Route::get('/subadmin-management', [UserController::class, 'index'])->name('subadmin.management');
    //   Route::get('/subadmin/create', [UserController::class, 'create'])->name('subadmin.create');
    //   Route::post('/subadmin/store', [UserController::class, 'store'])->name('subadmin.store');
    //  Route::get('/subadmin/edit/{id}', [UserController::class, 'edit'])->name('subadmin.edit');
    //  Route::put('/subadmin/update/{id}', [UserController::class, 'update'])->name('subadmin.update');
    //  Route::delete('/subadmin/destroy/{id}', [UserController::class, 'destroy'])->name('subadmin.destroy');
    // });


    //* Rutas para las funcionalidades del administrador y Subadministradores
    Route::middleware(['auth', 'role:admin|subadmin'])->group(function () {
        /* Administración de Usuarios */
        Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
        Route::get('/users/create', [AdminUserController::class, 'create'])->name('admin.users.create');
        Route::post('/users/store', [AdminUserController::class, 'store'])->name('admin.users.store');
        Route::get('/users/edit/{id}', [AdminUserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/users/update/{id}', [AdminUserController::class, 'update'])->name('admin.users.update');
        Route::delete('/users/destroy/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');

        /* Administración de libros */
        Route::get('/books', [BookController::class, 'index'])->name('books.index');
        Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
        Route::get('/book/create', [BookController::class, 'create'])->name('book.create');
        Route::post('/book/store', [BookController::class, 'store'])->name('book.store');
        Route::get('/book/edit/{id}', [BookController::class, 'edit'])->name('book.edit');
        Route::put('/book/update/{id}', [BookController::class, 'update'])->name('book.update');
        Route::delete('/book/destroy/{id}', [BookController::class, 'destroy'])->name('book.destroy');

        /* Administración de ediciones */
        Route::get('/edition-management', [EditionController::class, 'index'])->name('edition.management');
        Route::get('/edition/create', [EditionController::class, 'create'])->name('edition.create');
        Route::post('/edition/store', [EditionController::class, 'store'])->name('edition.store');
        Route::get('/edition/edit/{id}', [EditionController::class, 'edit'])->name('edition.edit');
        Route::put('/edition/update/{id}', [EditionController::class, 'update'])->name('edition.update');
        Route::delete('/edition/destroy/{id}', [EditionController::class, 'destroy'])->name('edition.destroy');
    });


    //* Rutas para las funcionalidades de Usuarios
    Route::middleware(['auth', 'role:user'])->group(function () {
        // Rutas para la suscripción
        Route::get('/subscribe', [SubscribeController::class, 'index'])->name('subscribe');
    });
});


//* Otras rutas pueden ir fuera del grupo de middleware si no requieren autenticación
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Auth::routes();

Route::get('/home', [AuthController::class, "index"])->name('home');
