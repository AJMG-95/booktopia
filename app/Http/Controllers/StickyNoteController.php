<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserStickyNote;

class StickyNoteController extends Controller
{
    /**
     * Muestra todas las notas del usuario.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $userNotes = UserStickyNote::where('user_id', auth()->user()->id)->get();
        return view('layouts.user.notes.notesList', compact('userNotes'));
    }

    /**
     * Muestra la vista detalle de una nota en concreto.
     *
     * @param  \App\Models\UserStickyNote  $stickyNote
     * @return \Illuminate\View\View
     */
    public function show(UserStickyNote $stickyNote)
    {
        return view('layouts.user.notes.notesShow', compact('stickyNote'));
    }

    /**
     * Muestra el formulario para crear una nota.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('layouts.user.notes.notesCreate');
    }

    /**
     * Almacena una nueva nota en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        UserStickyNote::create([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->route('sticky_note.index')->with('success', 'Nota creada con éxito');
    }

    /**
     * Muestra el formulario para editar una nota.
     *
     * @param  \App\Models\UserStickyNote  $stickyNote
     * @return \Illuminate\View\View
     */
    public function edit(UserStickyNote $stickyNote)
    {
        return view('layouts.user.notes.notesEdit', compact('stickyNote'));
    }

    /**
     * Actualiza la nota en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserStickyNote  $stickyNote
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, UserStickyNote $stickyNote)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $stickyNote->update([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
        ]);

        return redirect()->route('sticky_note.index')->with('success', 'Nota actualizada con éxito');
    }

    /**
     * Elimina la nota de la base de datos.
     *
     * @param  \App\Models\UserStickyNote  $stickyNote
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(UserStickyNote $stickyNote)
    {
        $stickyNote->delete();
        return redirect()->route('sticky_note.index')->with('success', 'Nota eliminada con éxito');
    }
}
