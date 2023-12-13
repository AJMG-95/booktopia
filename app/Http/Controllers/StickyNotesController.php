<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StickyNote;

class StickyNotesController extends Controller
{
    /**
     * Muestra todas las notas del usuario.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $userNotes = StickyNote::where('user_id', auth()->user()->id)->get();
        return view('layouts.user.notes.notesList', compact('userNotes'));
    }

    /**
     * Muestra la vista detalle de una nota en concreto.
     *
     * @param  \App\Models\StickyNote  $stickyNote
     * @return \Illuminate\View\View
     */
    public function show(StickyNote $stickyNote)
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

        StickyNote::create([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'user_id' => auth()->user()->id,
        ]);

        return redirect()->route('notes.index')->with('success', 'Nota creada con éxito');
    }

    /**
     * Muestra el formulario para editar una nota.
     *
     * @param  \App\Models\StickyNote  $stickyNote
     * @return \Illuminate\View\View
     */
    public function edit(StickyNote $stickyNote)
    {
        return view('layouts.user.notes.notesEdit', compact('stickyNote'));
    }

    /**
     * Actualiza la nota en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StickyNote  $stickyNote
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, StickyNote $stickyNote)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $stickyNote->update([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
        ]);

        return redirect()->route('notes.index')->with('success', 'Nota actualizada con éxito');
    }

    /**
     * Elimina la nota de la base de datos.
     *
     * @param  \App\Models\StickyNote  $stickyNote
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(StickyNote $stickyNote)
    {
        $stickyNote->delete();
        return redirect()->route('notes.index')->with('success', 'Nota eliminada con éxito');
    }
}
