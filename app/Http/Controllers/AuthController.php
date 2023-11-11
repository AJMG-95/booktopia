<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $rol = $user->role->rol_name;

        switch ($rol) {
            case 'admin':
            case 'subadmin':
                return view('authenticated.admin.home');
                break;

            case 'user':
                return view('welcome');
                break;

            default:
                return view('welcome');
                break;
        }
    }
}

