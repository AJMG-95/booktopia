<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;

class SubadminController extends Controller
{
    public function index()
    {
        $subadmins = User::all();
        return view('subadmin.management', compact('subadmins'));
    }

    public function create()
    {
        return view('subadmin.create');
    }

    public function store(Request $request)
    {
        // Validar y guardar el nuevo subadmin
    }

    public function edit($id)
    {
        $subadmin = User::find($id);
        return view('subadmin.edit', compact('subadmin'));
    }

    public function update(Request $request, $id)
    {
        // Validar y actualizar el subadmin existente
    }

    public function destroy($id)
    {
        // Eliminar el subadmin
    }
}
