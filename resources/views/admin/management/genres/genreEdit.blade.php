<!-- resources/views/admin/management/genres/genreEdit.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Editar Género</h2>

        <!-- Mostrar mensajes de éxito o error aquí -->

        <form method="post" action="{{ route('genres.update', $genre->id) }}" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <div class="mb-3">
                <label for="genre_name" class="form-label">Nombre del Género</label>
                <input type="text" class="form-control" id="genre_name" name="genre_name" value="{{ old('genre_name', $genre->genre_name) }}" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <textarea class="form-control" id="description" name="description">{{ old('description', $genre->description) }}</textarea>
            </div>

            <div class="mb-3">
                <p class="form-label">Imagen actual</p>
                @if($genre->img_url)
                    <img src="{{ asset('storage/' . $genre->img_url) }}" alt="Imagen actual del Género" >
                @endif
            </div>

            <div class="mb-3">
                <label for="img_url" class="form-label">Cambiar Imagen</label>
                <input type="file" class="form-control" id="img_url" name="img_url">
            </div>

            <button type="submit" class="btn btn-primary">Actualizar Género</button>
            <a href="{{ route('genres.list') }}" class="btn btn-danger ">Cancelar</a>
        </form>
    </div>
@endsection

