@extends('layouts.app')

@section('content')
    <div class="container mt-4 border rounded">
        <h2>Crear Autor</h2>

        <!-- Mostrar mensajes de éxito o error aquí -->

        <form action="{{ route('authors.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="nickname" class="form-label">Nickname:</label>
                <input type="text" class="form-control" id="nickname" name="nickname">
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="mb-3">
                <label for="surnames" class="form-label">Apellidos:</label>
                <input type="text" class="form-control" id="surnames" name="surnames">
            </div>

            <div class="mb-3">
                <label for="birth_at" class="form-label">Fecha de nacimiento:</label>
                <input type="date" class="form-control" id="birth_at" name="birth_at">
            </div>

            <div class="mb-3">
                <label for="country_id" class="form-label">País:</label>
                <select class="form-control" id="country_id" name="country_id">
                    <!-- Include options for countries -->
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="biography" class="form-label">Biografias:</label>
                <textarea class="form-control" id="biography" name="biography" rows="4"></textarea>
            </div>

            <div class="mb-3">
                <label for="photo" class="form-label">Foto:</label>
                <input type="file" class="form-control" id="photo" name="photo">
            </div>

            <button type="submit" class="btn btn-primary mb-3">Crear autor</button>
            <a href="{{ route('authors.list') }}" class="btn btn-primary  mb-3">Cancelar</a>

        </form>
    </div>
@endsection
