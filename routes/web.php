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

            // Lista de subadmins
            Route::get('/list', [SubadminCrudController::class, 'index'])->name('subadmins.list');

            // Formulario de creación de subadmins
            Route::get('/create', [SubadminCrudController::class, 'create'])->name('subadmins.create');

            // Acción para almacenar un nuevo subadmin
            Route::post('/store', [SubadminCrudController::class, 'store'])->name('subadmins.store');

            // Formulario de actualización de subadmins
            //* Route::get('/subadmins/edit/{id}', [SubadminCrudController::class, 'edit'])->name('subadmins.edit');
            // Lógica para actualizar subadmins (PUT o PATCH)
            //* Route::patch('/subadmins/update/{id}', [SubadminCrudController::class, 'update'])->name('subadmins.update');

            // Formulario de eliminación de subadmins
            // Route::get('/delete/{id}', [SubadminCrudController::class, 'delete'])->name('subadmins.delete');
            Route::get('/demote/{id}', [SubadminCrudController::class, 'demoteToUser'])->name('subadmins.demote');

            // Lógica para eliminar subadmins (DELETE)
            Route::get('/destroy/{id}', [SubadminCrudController::class, 'destroy'])->name('subadmins.destroy');
        });
    });


    //* Rutas para las funcionalidades del administrador y Subadministradores
    Route::middleware(['auth', 'role:[admin,|subadmin]'])->group(function () {
        /* Administración de Usuarios CRUD*/
        Route::prefix('admin/users')->group(function () {
            Route::get('/list', [UserCrudController::class, 'index'])->name('user.list');
            Route::get('/create', [UserCrudController::class, 'create'])->name('user.create');
            Route::post('/store', [UserCrudController::class, 'store'])->name('user.store');
            Route::get('/edit/{id}', [UserCrudController::class, 'edit'])->name('user.edit');
            Route::patch('/update/{id}', [UserCrudController::class, 'update'])->name('user.update');
            Route::get('/delete/{id}', [UserCrudController::class, 'delete'])->name('user.delete');
            Route::get('/destroy/{id}', [UserCrudController::class, 'destroy'])->name('user.destroy');
            Route::get('/promote/{id}', [UserCrudController::class, 'promoteToSubadmin'])->name('user.promote');
        });
        /* Administración de libros CRUD*/

        /* Administración de ediciones CRUD*/
    });


    //* Rutas para las funcionalidades de Usuarios
    Route::middleware(['auth', 'role:user'])->group(function () {
        // Rutas para la suscripción
    });
});


//* Otras rutas pueden ir fuera del grupo de middleware si no requieren autenticación
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Auth::routes();

Route::get('/home', [AuthController::class, "index"])->name('home');
