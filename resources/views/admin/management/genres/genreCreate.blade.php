<!-- resources/views/admin/management/genres/genreCreate.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Crear Nuevo Género</h2>

        <!-- Mostrar mensajes de éxito o error aquí -->

        <form action="{{ route('genres.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="genre_name" class="form-label">Nombre del Género</label>
                <input type="text" class="form-control" id="genre_name" name="genre_name" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label for="img_url" class="form-label">Imagen del Género</label>
                <input type="file" class="form-control" id="img_url" name="img_url">
            </div>

            <button type="submit" class="btn btn-primary">Guardar Género</button>
            <a href="{{ route('genres.list') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
