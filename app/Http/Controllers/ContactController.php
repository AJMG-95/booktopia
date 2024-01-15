<?php

// app/Http/Controllers/ContactController.php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function showForm()
    {
        return view('partials.contact_us');
    }

    public function submitForm(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        $user_id = Auth::id(); // Obtén el id del usuario autenticado

        ContactUs::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'message' => $request->input('message'),
            'status' => 'sin_leer',
            'user_id' => $user_id,
        ]);

        return redirect()->route('contact.form')->with('success', 'Mensaje enviado correctamente.');
    }
}
