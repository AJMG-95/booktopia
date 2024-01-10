<!-- resources/views/admin/management/books/bookCreate.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container mt-4 border rounded">
        <h2>Create Book</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('books.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-3">
                <label for="original_title">Titulo:</label>
                <input type="text" class="form-control" id="original_title" name="original_title" required>
            </div>

            <!-- Selección múltiple de autores -->
            <div class="form-group mb-3">
                <p>Autores:</p>
                @foreach ($authors as $author)
                    <label for="author_{{ $author->id }}">
                        @if ($author->nickname)
                            {{ $author->nickname }}
                        @else
                            {{ $author->surnames }}; {{ $author->name }}
                        @endif

                    </label>
                    <input type="checkbox" name="authors[]" id="author_{{ $author->id }}" value="{{ $author->id }}">
                @endforeach
            </div>

            <!-- Selección múltiple de géneros -->
            <div class="form-group mb-3">
                <p>Generos:</p>
                @foreach ($genres as $genre)
                    <label for="genre_{{ $genre->id }}">
                        {{ $genre->genre }}
                    </label>
                    <input type="checkbox" name="genres[]" id="genre_{{ $genre->id }}" value="{{ $genre->id }}">
                @endforeach
            </div>

            <div class="form-group mb-3">
                <label for="cover">Portada:</label>
                <input type="file" class="form-control" id="cover" name="cover" accept="image/*">
            </div>

            <div class="form-group mb-3">
                <label for="self_published">¿Auto-Publicado?:</label>
                <input type="checkbox" class="form-check" id="self_published" name="self_published" value="1">
            </div>

            <div class="form-group mb-3">
                <label for="visible">¿Visible?:</label>
                <input type="checkbox" class="form-check" id="visible" name="visible" value="1">
            </div>

            <button type="submit" class="btn btn-primary mb-3">Crear libro</button>
        </form>
    </div>
@endsection
