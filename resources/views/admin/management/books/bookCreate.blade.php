<!-- resources/views/admin/management/books/bookCreate.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container mt-4 border rounded">
        <h2>Crear Nuevo Libro</h2>

        <form action="{{ route('books.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <p class="form-label">Opciones de libro</p>
                <input type="checkbox" class="form-check-input" id="self_published" name="self_published" value="1"
                    {{ old('self_published') ? 'checked' : '' }}>
                <label for="self_published" class="form-label me-3">Autoedición</label>
                <input type="checkbox" class="form-check-input" id="for_adults" name="for_adults" value="1"
                    {{ old('for_adults') ? 'checked' : '' }}>
                <label for="for_adults" class="form-label  me-3">Libro para adultos</label>
                <input type="checkbox" class="form-check-input" id="visible" name="visible" value="1"
                    {{ old('visible') ? 'checked' : '' }}>
                <label for="visible" class="form-label">Visible</label>
            </div>

            <div class="mb-3">
                <label for="isbn" class="form-label">ISBN</label>
                <input type="text" class="form-control" id="isbn" name="isbn" value="{{ old('isbn') }}">
            </div>

            <div class="mb-3">

            </div>

            <div class="mb-3">
                <label for="title" class="form-label">Título</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
            </div>


            <div class="mb-3">
                <label for="cover" class="form-label">Portada</label>
                <input type="file" class="form-control" id="cover" name="cover">
            </div>

            <div class="mb-3">
                <label for="document" class="form-label">Documento (PDF)</label>
                <input type="file" class="form-control" id="document" name="document">
            </div>

            <div class="mb-3">
                <label class="form-label">Autores</label>
                <div style="max-height: 100px; overflow-y: auto;" class="bg-white rounded ps-1">
                    @foreach ($authors as $author)
                        <div class="form-check">
                            <input class="form-check-input text-black border-black  me-1" type="checkbox"
                                id="author_{{ $author->id }}" name="authors[]" value="{{ $author->id }}">
                            <label class="form-check-label text-black" for="author_{{ $author->id }}">
                                {{ $author->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Géneros</label>
                <div style="max-height: 100px; overflow-y: auto;" class="bg-white rounded ps-1">
                    @foreach ($genres as $genre)
                        <div class="form-check">
                            <input class="form-check-input text-black border-black me-1" type="checkbox"
                                id="genre_{{ $genre->id }}" name="genres[]" value="{{ $genre->id }}">
                            <label class="form-check-label text-black" for="genre_{{ $genre->id }}">
                                {{ $genre->genre_name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Idioma</label>
                <select class="form-select" id="language_id" name="language_id">
                    @foreach($languages as $language)
                        <option value="{{ $language->id }}" {{ old('language_id') == $language->id ? 'selected' : '' }}>
                            {{ $language->language }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="short_description" class="form-label">Descripción Corta</label>
                <textarea class="form-control" id="short_description" name="short_description">{{ old('short_description') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
            </div>


            <div class="mb-3">
                <label for="editorial" class="form-label">Editorial</label>
                <input type="text" class="form-control" id="editorial" name="editorial" value="{{ old('editorial') }}">
            </div>


            <div class="mb-3">
                <label for="price" class="form-label">Precio</label>
                <input type="text" class="form-control" id="price" name="price" value="{{ old('price') }}">
            </div>


            <button type="submit" class="btn btn-primary mb-3">Crear Libro</button>
            <a href="{{ route('books.list') }}" class="btn btn-danger mb-3">Cancelar</a>
        </form>
    </div>
@endsection
