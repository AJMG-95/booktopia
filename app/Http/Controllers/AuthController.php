<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->role->rol_name;

        $adminRoles = ['admin', 'subadmin'];

        if (in_array($role, $adminRoles)) {
            return view('admin.home');
        } elseif ($role === 'user') {
            return view('welcome');
        } else {
            // Consider a different action for the default case, e.g., showing an error page
            return view('error')->with('message', 'Acceso no autorizado.');
        }
    }
}
