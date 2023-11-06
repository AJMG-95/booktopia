<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubadminController extends Controller
{
    public function index()
    {
        // Aquí puedes agregar la lógica para la vista del subadmin
        return view('subadmin.index');
    }
}
