<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\BookComment;
use App\Models\UserPost;


class UserController extends Controller
{
    public function List()
    {
        $users = User::where('rol_id', 3)->where('deleted', false)->get();
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
            'country_id' => 'nullable|exists:countries,id',
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
            'biography' => $validatedData['biography'],
        ]);

        return redirect()->route('user.list')->with('success', 'Usuario creado exitosamente.');
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'nickname' => 'required|string',
            'name' => 'required|string',
            'birth_date' => 'nullable|date',
            'country_id' => 'nullable|exists:countries,id',
            'profile_img' => 'nullable|string',
            'biography' => 'nullable|string',
        ]);

        $user = User::findOrFail($id);
        $user->nickname = $request->input('nickname');
        $user->name = $request->input('name');
        $user->birth_date = $request->input('birth_date');
        $user->country_id = $request->input('country_id');
        $user->profile_img = $request->input('profile_img');
        $user->biography = $request->input('biography');
        $user->save();

        return redirect()->route('user.list')->with('success', 'Usuario actualizado exitosamente.');
    }

    public function edit($id)
    {
        $countries = Country::all();
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.management.users.userEdit', compact('user', 'roles', 'countries'));
    }

    /*     public function delete($id)
    {
        return view('user.delete', compact('id'));
    } */

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

    public function subadminList()
    {
        $subadmins = User::where('rol_id', 2)->where('deleted', false)->get();
        return view('admin.management.subadmins.subadminList', compact('subadmins'));
    }

    public function subadminCreate()
    {
        $countries = Country::all();
        $roles = Role::all();
        return view('admin.management.subadmins.subadminCreate', compact('roles', 'countries'));
    }

    public function subadminStore(Request $request)
    {
        $validatedData = $request->validate([
            'nickname' => 'required|unique:users,nickname|max:255',
            'name' => 'required|string|max:255',
            'surnames' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $subadmin = User::create([
            'nickname' => $validatedData['nickname'],
            'name' => $validatedData['name'],
            'surnames' => $validatedData['surnames'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'rol_id' => 2,
        ]);

        return redirect()->route('subadmins.list')->with('success', 'Usuario creado exitosamente.');
    }

    public function subadminUpdate(Request $request, $id)
    {

        $request->validate([
            'nickname' => 'required|string',
            'name' => 'required|string',
            'profile_img' => 'nullable|string',
        ]);

        $subadmin = User::findOrFail($id);
        $subadmin->nickname = $request->input('nickname');
        $subadmin->name = $request->input('name');
        $subadmin->profile_img = $request->input('profile_img');
        $subadmin->save();

        return redirect()->route('subadmins.list')->with('success', 'Usuario actualizado exitosamente.');
    }

    public function subadminEdit($id)
    {
        $countries = Country::all();
        $subadmin = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.management.subadmins.subadminEdit', compact('subadmin', 'roles', 'countries'));
    }

    public function subadminDestroy($id)
    {
        $subadmin = User::findOrFail($id);
        $subadmin->delete();
        return redirect()->route('subadmins.list')->with('success', 'Usuario eliminado exitosamente.');
    }

    /**
     * Mostrar la vista con todos los comentarios a libros realizados por el usuario conectado.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function UserCommentsAndPosts()
    {
        // Obtén el ID del usuario conectado
        $userId = Auth::id();

        // Obtén todos los comentarios a libros del usuario
        $userComments = BookComment::where('user_id', $userId)->get();
          // Obtiene todos los posts del usuario autenticado
        $userPosts = UserPost::where('user_id', $userId)->get();

        // Puedes pasar los comentarios a la vista
        return view('layouts.user.comments&posts.comments_posts', ['userPosts' => $userPosts, 'userComments' => $userComments]);
    }
}
