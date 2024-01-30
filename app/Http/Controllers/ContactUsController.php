<?php

// en el archivo app/Http/Controllers/ContactUsController.php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ContactUsController extends Controller
{
    public function index()
    {
        $messages = ContactUs::all();

        return view('admin.management.contact_us.contact_us', compact('messages'));
    }

    public function create()
    {
        return view('layouts.contact_us_form');
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'sender_email' => 'required|email',
                'title' => 'required|string',
                'body'  => 'required|string',
            ]);

            ContactUs::create($validatedData);

            return redirect()->route('contact_us.form')->with('success', 'Mensaje envido con exito');
        } catch (ValidationException $e) {
            // Manejo de excepciones de validación
            dd($e);
            return redirect()->route('contact_us.form')->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Manejo de otras excepciones
            dd($e);
            return redirect()->route('contact_us.form')->with('error', 'Se ha producido un error al enviar el formulario');
        }
    }

    public function show($id)
    {
        $message = ContactUs::findOrFail($id);

        return view('admin.management.contact_us.show', compact('message'));
    }

    public function edit(ContactUs $contactUs)
    {
        // Lógica para mostrar el formulario de edición
    }

    public function update(Request $request, ContactUs $contactUs)
    {
        // Lógica para actualizar un contacto
    }

    public function destroy(ContactUs $contactUs)
    {
        // Lógica para eliminar un contacto
    }


    public function toggleStatus($id)
    {
        $message = ContactUs::findOrFail($id);
        $message->status = $message->status === 'open' ? 'closed' : 'open';
        $message->save();

        return redirect()->route('contact_us.admin_index')->with('success', 'Status updated successfully.');
    }

}
