<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SubadminCrudController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Obtener todos los subadmins
        $subadmins = User::where('rol_id', 2)->get();

        // Devolver la vista con los datos
        return view('admin.management.subadmins.subadminList', compact('subadmins'));
    }

    public function create()
    {
        // Lógica para mostrar el formulario de creación de subadmins
        return view('admin.management.subadmins.subadminCreate');
    }

    // Lógica para almacenar nuevos subadmins (puede que necesites una función store aquí)

    public function update($id)
    {
        // Lógica para mostrar el formulario de actualización de subadmins
        return view('admin.management.subadmins.subadminUpdate', compact('id'));
    }

    // Lógica para actualizar subadmins (puede que necesites una función update aquí)

    public function delete($id)
    {
        // Lógica para mostrar el formulario de eliminación de subadmins
        return view('admin.management.subadmins.subadminDelete', compact('id'));
    }

    // Lógica para eliminar subadmins (puede que necesites una función destroy aquí)


    public function demoteToUser($id)
    {
        $subadmin = User::findOrFail($id);

        // Verifica que el usuario sea un subadmin antes de cambiar el rol
        if ($subadmin->hasRole('subadmin')) {
            $subadmin->rol_id = 3; // Rol de usuario
            $subadmin->save();
            return redirect()->route('subadmins.list')->with('success', 'El subadmin se ha degradado a usuario exitosamente.');
        } else {
            return redirect()->route('subadmins.list')->with('error', 'El usuario no es un subadmin.');
        }
    }
    // Otros métodos para el CRUD de subadmins según sea necesario
}
