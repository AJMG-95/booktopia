<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SubscribeController;


//*Rutas del grupo de middleware que requieren autenticación
Route::middleware(['auth'])->group(function () {


    //* Rutas para las funcionalidades del administrador
    Route::middleware(['auth', 'role:admin'])->group(function () {
        /* Administración de Subadmins */
        Route::get('/subadmins', [UserController::class, 'showAllSubadmins'])->name('subadmins.show');
        Route::get('/subadmin-management', [UserController::class, 'index'])->name('subadmin.management');
        Route::get('/subadmin/create', [UserController::class, 'create'])->name('subadmin.create');
        Route::post('/subadmin/store', [UserController::class, 'store'])->name('subadmin.store');
        Route::get('/subadmin/edit/{id}', [UserController::class, 'edit'])->name('subadmin.edit');
        Route::put('/subadmin/update/{id}', [UserController::class, 'update'])->name('subadmin.update');
        Route::delete('/subadmin/destroy/{id}', [UserController::class, 'destroy'])->name('subadmin.destroy');
    });


    //* Rutas para las funcionalidades del administrador y Subadministradores
    Route::middleware(['auth', 'role:admin|subadmin'])->group(function () {
        /* Administración de Usuarios */
        Route::get('/users', [UserController::class, 'showAllUsers'])->name('users.show');
        Route::get('/user-management', [UserController::class, 'index'])->name('user.management');
        Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
        Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/user/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');

        /* Administración de libros */
        Route::get('/book-management', [BookController::class, 'index'])->name('book.management');
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
