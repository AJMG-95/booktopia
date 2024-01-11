{{-- resources.views.admin.management.authors.authorEdit.blade.php --}}

@extends('layouts.app')

@section('content')
    <div class="container mt-4 border rounded">
        <h2>Editar Autor</h2>

        <!-- Mostrar mensajes de éxito o error aquí -->

        <form action="{{route('authors.update', ['id' => $author->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <label for="nickname" class="form-label">Nickname:</label>
                <input type="text" class="form-control" id="nickname" name="nickname"
                    value="{{ old('nickname', $author->nickname) }}">
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="name" name="name"
                    value="{{ old('name', $author->name) }}">
            </div>

            <div class="mb-3">
                <label for="surnames" class="form-label">Apellidos:</label>
                <input type="text" class="form-control" id="surnames" name="surnames"
                    value="{{ old('surnames', $author->surnames) }}">
            </div>

            <div class="mb-3">
                <label for="birth_at" class="form-label">Fecha de nacimiento:</label>
                <input type="date" class="form-control" id="birth_at" name="birth_at"
                    value="{{ old('birth_at', $author->birth_at) }}">
            </div>

            <div class="mb-3">
                <label for="country_id" class="form-label">País:</label>
                <select class="form-control" id="country_id" name="country_id">
                    <!-- Include options for countries -->
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}" {{ $author->country_id == $country->id ? 'selected' : '' }}>
                            {{ $country->country_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="biography" class="form-label">Biography:</label>
                <textarea class="form-control" id="biography" name="biography" rows="4">{{ old('biography', $author->biography) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="photo" class="form-label">Foto:</label>
                <input type="file" class="form-control" id="photo" name="photo">
            </div>

            <button type="submit" class="btn btn-primary mb-3">Actualizar Autor</button>
            <a href="{{ route('authors.list') }}" class="btn btn-danger  mb-3">Cancelar</a>
        </form>
    </div>
@endsection
