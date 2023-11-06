<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


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


Route::middleware(['auth', 'role:admin'])->group(function () {
    // Rutas que solo pueden ser accedidas por usuarios con el rol "admin"
});


Route::get('/user', 'UserController@index')->middleware('auth', 'checkRole:user');
Route::get('/subadmin', 'SubadminController@index')->middleware('auth', 'checkRole:subadmin');
Route::get('/admin', 'AdminController@index')->middleware('auth', 'checkRole:admin');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
