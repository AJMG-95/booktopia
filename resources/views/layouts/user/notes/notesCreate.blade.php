@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Crear Nueva Nota</h1>

        <form action="{{ route('notes.store') }}" method="POST">
            @csrf

            <label for="title">Título:</label>
            <input type="text" name="title" value="{{ old('title') }}" required>

            <label for="body">Cuerpo:</label>
            <textarea name="body" required>{{ old('body') }}</textarea>

            <button type="submit">Guardar Nota</button>
        </form>

        <a href="{{ route('notes.index') }}">Cancelar y volver a la lista de notas</a>
    </div>
@endsection
