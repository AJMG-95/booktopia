<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

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
        // Obtén todos los roles disponibles
        $roles = Role::all();

        return view('admin.management.subadmins.subadminCreate', compact('roles'));
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'nickname' => 'required|unique:users,nickname|max:255',
            'name' => 'required|string|max:255',
            'surnames' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Crear el subadmin utilizando el modelo específico
        $subadmin = User::create([
            'nickname' => $validatedData['nickname'], // Puedes dejar el nickname fijo o cambiarlo según tus necesidades
            'name' => $validatedData['name'],
            'surnames' => $validatedData['surnames'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'rol_id' => 2, // Asumiendo que el ID del rol para subadmins es 2
        ]);

        return redirect()->route('subadmins.list')->with('success', 'Subadmin creado exitosamente.');
    }

    public function update(Request $request, $id)
    {
        // Valida los datos del formulario
        $request->validate([
            'nickname' => 'required|string',
            'name' => 'required|string',
            // Agrega las validaciones para otros campos si es necesario
            'role_id' => 'required|exists:roles,id',
        ]);

        // Encuentra el subadmin que se está actualizando
        $subadmin = User::findOrFail($id);

        // Actualiza los campos con los nuevos valores
        $subadmin->nickname = $request->input('nickname');
        $subadmin->name = $request->input('name');
        // Actualiza otros campos según sea necesario
        $subadmin->rol_id = $request->input('role_id');

        // Guarda los cambios en la base de datos
        $subadmin->save();

        // Redirige de vuelta a la lista de subadmins con un mensaje de éxito
        return redirect()->route('subadmins.list')->with('success', 'Subadmin actualizado exitosamente.');
    }


    public function edit($id)
    {
        // Obtén el subadmin que deseas editar
        $subadmin = User::findOrFail($id);

        // Obtén todos los roles disponibles
        $roles = Role::all();

        // Pasa los datos a la vista de edición
        return view('admin.management.subadmins.subadminEdit', compact('subadmin', 'roles'));
    }

    public function delete($id)
    {
        // Lógica para mostrar el formulario de eliminación de subadmins
        return view('admin.management.subadmins.subadminDelete', compact('id'));
    }

    public function destroy($id)
    {
        $subadmin = User::findOrFail($id);

        // Actualizar los campos y marcar como "eliminado"
        $subadmin->update([
            'nickname' => null,
            'email' => null,
            'password' => null,
            'birth_date' => null,
            'country_id' => null,
            'profile_img' => null,
            'rol_id' => null,
            'strikes' => null,
            'blocked' => false,
            'deleted' => true,
        ]);

        // Redirigir o realizar otras acciones después de la "eliminación"
        return redirect()->route('subadmins.list')->with('success', 'Subadmin eliminado exitosamente.');
    }



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
