<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BookController;
use App\Http\Controllers\SubadminController;
use App\Http\Controllers\AuthController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [AuthController::class, "index"]);

Auth::routes();

// Rutas para las funcionalidades del administrador
// Rutas para las vistas de gestión
Route::get('/user-management', function () {
    return view('user.management');
})->name('user.management');

Route::get('/book-management', function () {
    return view('book.management');
})->name('book.management');

Route::get('/subadmin-management', function () {
    return view('subadmin.management');
})->name('subadmin.management');
