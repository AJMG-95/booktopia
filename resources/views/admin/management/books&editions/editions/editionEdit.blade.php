<!-- resources/views/admin/management/books&editions/editions/editionEdit.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Edition</h2>

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

        <form action="{{ route('editions.update', ['id' => $edition->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="book_id" class="form-label">Libro</label>
                <select class="form-select" id="book_id" name="book_id" >
                    @foreach ($books as $book)
                        <option value="{{ $book->id }}" @if ($book->id === $edition->book_id) selected @endif>{{ $book->original_title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="isbn" class="form-label">ISBN</label>
                <input type="text" class="form-control" id="isbn" name="isbn" value="{{ old('isbn', $edition->isbn) }}">
            </div>

            <div class="mb-3">
                <label for="title" class="form-label">Título</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $edition->title) }}">
            </div>

            <div class="mb-3">
                <label for="editorial" class="form-label">Editorial</label>
                <input type="text" class="form-control" id="editorial" name="editorial" value="{{ old('editorial', $edition->editorial) }}">
            </div>

            <div class="mb-3">
                <label for="publication_date" class="form-label">Fecha de Publicación</label>
                <input type="date" class="form-control" id="publication_date" name="publication_date" value="{{ old('publication_date', $edition->publication_date) }}" required>
            </div>

            <div class="mb-3">
                <label for="language_id" class="form-label">Idioma</label>
                <select class="form-select" id="language_id" name="language_id" required>
                    @foreach ($languages as $language)
                        <option value="{{ $language->id }}" @if ($language->id === $edition->language_id) selected @endif>{{ $language->language }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Precio</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ old('price', $edition->price) }}" >
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $edition->description) }}</textarea>
            </div>

            <div class="mb-3">
                <label for="cover" class="form-label">Cover</label>
                <input type="file" class="form-control" id="cover" name="cover" accept="image/*">
            </div>

            <div class="mb-3">
                <label for="document" class="form-label">Documento PDF</label>
                <input type="file" class="form-control" id="document" name="document" accept=".pdf">
            </div>

            <button type="submit" class="btn btn-primary">Actualizar Edición</button>
        </form>
    </div>
@endsection
