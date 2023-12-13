@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Editar Nota</h1>

        <form action="{{ route('notes.update', $stickyNote) }}" method="POST">
            @csrf
            @method('PUT')

            <label for="title">Título:</label>
            <input type="text" name="title" value="{{ old('title', $stickyNote->title) }}" required>

            <label for="body">Cuerpo:</label>
            <textarea name="body" required>{{ old('body', $stickyNote->body) }}</textarea>

            <button type="submit">Guardar Cambios</button>
        </form>

        <a href="{{ route('notes.show', $stickyNote) }}">Cancelar y volver a la vista de detalle</a>
    </div>
@endsection
