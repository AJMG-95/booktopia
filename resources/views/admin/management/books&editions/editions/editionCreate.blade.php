<!-- resources/views/admin/management/books&editions/editions/editionCreate.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Create Edition</h2>

        <!-- Mostrar mensajes de éxito o error aquí -->
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

        <form action="{{ route('editions.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="book_id" class="form-label">Libro</label>
                <select class="form-select" id="book_id" name="book_id" required>
                    @foreach ($books as $book)
                        <option value="{{ $book->id }}">{{ $book->original_title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="isbn" class="form-label">ISBN</label>
                <input type="text" class="form-control" id="isbn" name="isbn" required>
            </div>

            <div class="mb-3">
                <label for="title" class="form-label">Título</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="mb-3">
                <label for="editorial" class="form-label">Editorial</label>
                <input type="text" class="form-control" id="editorial" name="editorial" required>
            </div>

            <div class="mb-3">
                <label for="publication_date" class="form-label">Fecha de Publicación</label>
                <input type="date" class="form-control" id="publication_date" name="publication_date" required>
            </div>

            <div class="mb-3">
                <label for="language_id" class="form-label">Idioma</label>
                <select class="form-select" id="language_id" name="language_id" required>
                    @foreach ($languages as $language)
                        <option value="{{ $language->id }}">{{ $language->language }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Precio</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label for="cover" class="form-label">Cover</label>
                <input type="file" class="form-control" id="cover" name="cover" accept="image/*" required>
            </div>

            <div class="mb-3">
                <label for="document" class="form-label">Documento PDF</label>
                <input type="file" class="form-control" id="document" name="document" accept=".pdf" required>
            </div>

            <button type="submit" class="btn btn-primary">Crear Edición</button>
        </form>
    </div>
@endsection
