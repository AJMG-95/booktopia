<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\User;

class UserController extends Controller
{
    public function List()
    {
        $users = User::where('rol_id', 3)->where('deleted', false)->get();
        return view('admin.management.users.userList', compact('users'));
    }

    public function subadminList()
    {
        $users = User::where('rol_id', 2)->where('deleted', false)->get();
        return view('admin.management.users.userList', compact('users'));
    }

    public function create()
    {
        $countries = Country::all();
        $roles = Role::all();
        return view('admin.management.users.userCreate', compact('roles', 'countries'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nickname' => 'required|unique:users,nickname|max:255',
            'name' => 'required|string|max:255',
            'surnames' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'birth_date' => 'nullable|date',
            'country_id' => 'nullable|exists:countries,id|unsigned',
            'profile_img' => 'nullable|string',
            'biography' => 'nullable|string',
        ]);

        $user = User::create([
            'nickname' => $validatedData['nickname'],
            'name' => $validatedData['name'],
            'surnames' => $validatedData['surnames'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'rol_id' => 3,
            'birth_date' => $validatedData['birth_date'],
            'country_id' => $validatedData['country_id'],
            'profile_img' => $validatedData['profile_img'],
            'biography' => $validatedData['biography'],
        ]);

        return redirect()->route('user.list')->with('success', 'Usuario creado exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nickname' => 'required|string',
            'name' => 'required|string',
            'role_id' => 'required|exists:roles,id',
            'birth_date' => 'nullable|date',
            'country_id' => 'nullable|exists:countries,id|unsigned',
            'profile_img' => 'nullable|string',
            'biography' => 'nullable|string',
        ]);

        $user = User::findOrFail($id);
        $user->nickname = $request->input('nickname');
        $user->name = $request->input('name');
        $user->rol_id = $request->input('role_id');
        $user->birth_date = $request->input('birth_date');
        $user->country_id = $request->input('country_id');
        $user->profile_img = $request->input('profile_img');
        $user->biography = $request->input('biography');
        $user->save();

        return redirect()->route('user.list')->with('success', 'Usuario actualizado exitosamente.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.management.users.userEdit', compact('user', 'roles'));
    }

    public function delete($id)
    {
        return view('admin.management.users.userDelete', compact('id'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->update([
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

        return redirect()->route('user.list')->with('success', 'Usuario eliminado exitosamente.');
    }

    public function promoteToSubadmin($id)
    {
        $user = User::findOrFail($id);

        if (!$user->hasRole('subadmin') && !$user->hasRole('admin')) {
            $user->rol_id = 2;
            $user->save();
            return redirect()->route('user.list')->with('success', 'El usuario ha sido ascendido a subadmin exitosamente.');
        } else {
            return redirect()->route('user.list')->with('error', 'El usuario ya es un subadmin o admin.');
        }
    }

    public function toggleBlock($id)
    {
        $user = User::findOrFail($id);
        $user->blocked = !$user->blocked;
        $user->save();

        $message = $user->blocked ? 'Usuario bloqueado exitosamente.' : 'Usuario desbloqueado exitosamente.';

        return redirect()->route('user.list')->with('success', $message);
    }

    // Otros métodos para el CRUD de usuarios según sea necesario
}
