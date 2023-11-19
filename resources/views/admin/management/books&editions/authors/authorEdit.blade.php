{{-- resources.views.admin.management.books&editions.authors.authorEdit.blade.php --}}

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Author</h2>

        <!-- Mostrar mensajes de éxito o error aquí -->

        <form action="{{ route('authors.update', $author->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $author->name }}" required>
            </div>

            <div class="mb-3">
                <label for="surnames" class="form-label">Apellidos:</label>
                <input type="text" class="form-control" id="surnames" name="surnames" value="{{ $author->surnames }}" required>
            </div>

            <div class="mb-3">
                <label for="birth_at" class="form-label">Fecha de nacimiento:</label>
                <input type="date" class="form-control" id="birth_at" name="birth_at" value="{{ $author->birth_at }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="country_id" class="form-label">Country:</label>
                <select class="form-control" id="country_id" name="country_id" required>
                    <!-- Include options for countries -->
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}" @if ($country->id == $author->country_id) selected @endif>{{ $country->country_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="biography" class="form-label">Biography:</label>
                <textarea class="form-control" id="biography" name="biography" rows="4" required>{{ $author->biography }}</textarea>
            </div>

            <!-- Add more fields as needed -->

            <button type="submit" class="btn btn-primary">Update Author</button>
        </form>
    </div>
@endsection
