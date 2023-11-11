<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BookController;
use App\Http\Controllers\SubadminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SubscribeController;


//*Rutas del grupo de middleware que requieren autenticación
Route::middleware(['auth'])->group(function () {

    //* Rutas para las funcionalidades del administrador
    Route::middleware(['auth', 'role:admin'])->group(function () {
        /* Administración de Usuarios */
        Route::get('/user-management', [UserController::class, 'index'])->name('user.management');
        Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
        Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/user/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');

        /* Administración de Subadmins */
        Route::get('/subadmin-management', [SubadminController::class, 'index'])->name('subadmin.management');
        Route::get('/subadmin/create', [SubadminController::class, 'create'])->name('subadmin.create');
        Route::post('/subadmin/store', [SubadminController::class, 'store'])->name('subadmin.store');
        Route::get('/subadmin/edit/{id}', [SubadminController::class, 'edit'])->name('subadmin.edit');
        Route::put('/subadmin/update/{id}', [SubadminController::class, 'update'])->name('subadmin.update');
        Route::delete('/subadmin/destroy/{id}', [SubadminController::class, 'destroy'])->name('subadmin.destroy');

        /* Administración de libros */
        Route::get('/book-management', function () {
            return view('book.management');
        })->name('book.management');
    });


    //* Rutas para las funcionalidades de Subadministradores
    Route::middleware(['auth', 'role:subadmin'])->group(function () {

        /* Administración de Usuarios */
        Route::get('/user-management', [UserController::class, 'index'])->name('user.management');
        Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
        Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/user/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');

        /* Administración de libros */
        Route::get('/book-management', function () {
            return view('book.management');
        })->name('book.management');
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
