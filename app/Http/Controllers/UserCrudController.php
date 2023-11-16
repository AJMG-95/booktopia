<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\User;

class UserCrudController extends Controller
{
    public function index()
    {
        // Lógica para mostrar la lista de usuarios
        $users = User::where('rol_id', 3)->get();
        return view('admin.management.users.userList', compact('users'));
    }

    public function create()
    {
        // Obtén todos los roles disponibles
        $roles = Role::all();

        return view('admin.management.users.userCreate', compact('roles'));
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

        // Crear el usuario utilizando el modelo específico
        $user = User::create([
            'nickname' => $validatedData['nickname'],
            'name' => $validatedData['name'],
            'surnames' => $validatedData['surnames'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'rol_id' => 3, // Rol de usuario
        ]);

        return redirect()->route('users.list')->with('success', 'Usuario creado exitosamente.');
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

        // Encuentra el usuario que se está actualizando
        $user = User::findOrFail($id);

        // Actualiza los campos con los nuevos valores
        $user->nickname = $request->input('nickname');
        $user->name = $request->input('name');
        // Actualiza otros campos según sea necesario
        $user->rol_id = $request->input('role_id');

        // Guarda los cambios en la base de datos
        $user->save();

        // Redirige de vuelta a la lista de usuarios con un mensaje de éxito
        return redirect()->route('users.list')->with('success', 'Usuario actualizado exitosamente.');
    }

    public function edit($id)
    {
        // Obtén el usuario que deseas editar
        $user = User::findOrFail($id);

        // Obtén todos los roles disponibles
        $roles = Role::all();

        // Pasa los datos a la vista de edición
        return view('admin.management.users.userEdit', compact('user', 'roles'));
    }

    public function delete($id)
    {
        // Lógica para mostrar el formulario de eliminación de usuarios
        return view('admin.management.users.userDelete', compact('id'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Elimina definitivamente al usuario
        $user->delete();

        return redirect()->route('users.list')->with('success', 'El usuario ha sido eliminado definitivamente.');
    }

    public function promoteToSubadmin($id)
    {
        $user = User::findOrFail($id);

        // Verifica que el usuario no sea ya un subadmin o admin antes de cambiar el rol
        if (!$user->hasRole('subadmin') && !$user->hasRole('admin')) {
            $user->rol_id = 2; // Rol de subadmin
            $user->save();
            return redirect()->route('users.list')->with('success', 'El usuario ha sido ascendido a subadmin exitosamente.');
        } else {
            return redirect()->route('users.list')->with('error', 'El usuario ya es un subadmin o admin.');
        }
    }

    // Otros métodos para el CRUD de usuarios según sea necesario
}
