@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Detalles de la Nota</h1>

        <h2>{{ $stickyNote->title }}</h2>
        <p>{{ $stickyNote->body }}</p>

        <p>Creada por: {{ $stickyNote->user->name }}</p>

        <a href="{{ route('notes.edit', $stickyNote) }}">Editar Nota</a>

        <form action="{{ route('notes.destroy', $stickyNote) }}" method="POST" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('¿Estás seguro de eliminar esta nota?')">Eliminar Nota</button>
        </form>

        <a href="{{ route('notes.index') }}">Volver a la lista de notas</a>
    </div>
@endsection
