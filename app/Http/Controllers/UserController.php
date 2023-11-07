<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index()
    {
        // Obtener el rol del usuario
        $rol = Auth::user()->role->rol_name;

        if ($rol == 'user') {
            return view('user.home');
        } elseif ($rol == 'admin') {
            return view('admin.home');
        } else {
            return view('subadmin.home');
        }
    }
}
