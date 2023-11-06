<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Aquí puedes agregar la lógica para la vista de usuario
        return view('user.index');
    }
}
