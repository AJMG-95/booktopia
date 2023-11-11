<?php


namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nickname' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'surnames' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'birth_date' => 'nullable|date',
            'country_id' => 'nullable|exists:countries,id',
            'img' => 'nullable|string',
            'rol_id' => 'nullable|exists:roles,id',
            'blocked' => 'nullable|boolean',
            'strikes' => 'nullable|integer',
        ]);

        $user = new User($request->all());
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return redirect()->route('user.management')->with('success', 'User created successfully.');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('user.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nickname' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'surnames' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'birth_date' => 'nullable|date',
            'country_id' => 'nullable|exists:countries,id',
            'img' => 'nullable|string',
            'rol_id' => 'nullable|exists:roles,id',
            'blocked' => 'nullable|boolean',
            'strikes' => 'nullable|integer',
        ]);

        $user->fill($request->all());

        // Actualizamos la contraseña si se proporcionó una nueva
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        return redirect()->route('user.management')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user.management')->with('success', 'User deleted successfully.');
    }
}
