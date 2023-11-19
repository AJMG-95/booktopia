<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SubadminCrudController;
use App\Http\Controllers\UserCrudController;

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
        });

        //Administración de libros y ediciones
        Route::prefix('admin/books&editions')->group(function () {
            Route::get('/index', function () {
                return view('admin.management.books&editions.index');
            })->name('books&editions.index');
            /* Administración de libros CRUD*/

            /* Administración de ediciones CRUD*/
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
