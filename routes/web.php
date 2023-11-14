<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SubadminCrudController;

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
            Route::post('/subadmins/store', [SubadminCrudController::class, 'store'])->name('subadmins.store');

            // Formulario de actualización de subadmins
            //* Route::get('/subadmins/edit/{id}', [SubadminCrudController::class, 'edit'])->name('subadmins.edit');
            // Lógica para actualizar subadmins (PUT o PATCH)
            //* Route::patch('/subadmins/update/{id}', [SubadminCrudController::class, 'update'])->name('subadmins.update');

            // Formulario de eliminación de subadmins
            // Route::get('/delete/{id}', [SubadminCrudController::class, 'delete'])->name('subadmins.delete');
            Route::get('/subadmins/demote/{id}', [SubadminCrudController::class, 'demoteToUser'])->name('subadmins.demote');

            // Lógica para eliminar subadmins (DELETE)
            Route::get('/subadmins/destroy/{id}', [SubadminCrudController::class, 'destroy'])->name('subadmins.destroy');
        });
    });










    //* Rutas para las funcionalidades del administrador y Subadministradores
    Route::middleware(['auth', 'role:admin|subadmin'])->group(function () {
        /* Administración de Usuarios CRUD*/

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
