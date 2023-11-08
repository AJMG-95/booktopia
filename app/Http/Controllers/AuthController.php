<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function index()
    {
        // Obtener el rol del usuario
        $rol = Auth::user()->role->rol_name;

        if ($rol == 'admin' || $rol == 'subadmin') {
            return view('admin.home');
        } elseif ($rol == 'user') {
            return view('user.home');
        } else {
            return view('welcome');
        }
    }
}
