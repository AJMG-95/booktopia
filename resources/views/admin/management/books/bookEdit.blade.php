@extends('layouts.app')

@section('content')
    <div class="container mt-4 border rounded">
        <h2>Crear Nuevo Libro</h2>

        <form action="{{ route('books.update', $editionBook->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <p class="form-label">Opciones de libro</p>
                <input type="checkbox" class="form-check-input" id="self_published" name="self_published" value="1"
                    {{ $editionBook->self_published ? 'checked' : '' }}>
                <label for="self_published" class="form-label me-3">Autoedición</label>
                <input type="checkbox" class="form-check-input" id="for_adults" name="for_adults" value="1"
                    {{ $editionBook->for_adults ? 'checked' : '' }}>
                <label for="for_adults" class="form-label  me-3">Libro para adultos</label>
                <input type="checkbox" class="form-check-input" id="visible" name="visible" value="1"
                    {{ $editionBook->visible ? 'checked' : '' }}>
                <label for="visible" class="form-label">Visible</label>
            </div>

            <div class="mb-3">
                <label for="isbn" class="form-label">ISBN</label>
                <input type="text" class="form-control" id="isbn" name="isbn" value="{{ $editionBook->isbn }}">
            </div>

            <div class="mb-3">
                <label for="title" class="form-label">Título</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $editionBook->title }}">
            </div>


            <div class="mb-3">
                <label for="cover" class="form-label">Imagen actual: </label>
                @if (isset($editionBook) && $editionBook->cover)
                    <img src="{{ asset('storage/' . $editionBook->cover) }}" alt="Imagen del Género" class="rounded "
                        style="max-height: 15vh">
                @else
                    No imagen
                @endif
            </div>

            <div class="mb-3">
                <label for="cover" class="form-label">Nueva Portada</label>
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
                            <input type="checkbox" name="authors[]" id="author_{{ $author->id }}"
                                value="{{ $author->id }}"
                                {{ $editionBook->authors->contains('id', $author->id) ? 'checked' : '' }}>
                            <label for="author_{{ $editionBook->id }}">
                                {{ $author->name }} {{ $author->surnames }}
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
                            <input type="checkbox" name="genres[]" id="genre_{{ $genre->id }}"
                                value="{{ $genre->id }}"
                                {{ $editionBook->genres->contains('id', $genre->id) ? 'checked' : '' }}>
                            <label for="genre_{{ $genre->id }}">
                                {{ $genre->genre_name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Idioma</label>
                <select class="form-select" id="language_id" name="language_id">
                    @foreach ($languages as $language)
                        <option value="{{ $language->id }}"
                            {{ $language->id == $editionBook->language_id ? 'selected' : '' }}>
                            {{$language->language}}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="short_description" class="form-label">Descripción Corta</label>
                <textarea class="form-control" id="short_description" name="short_description">{{$editionBook->short_description}}</textarea>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <textarea class="form-control" id="description" name="description">{{$editionBook->description}}</textarea>
            </div>


            <div class="mb-3">
                <label for="editorial" class="form-label">Editorial</label>
                <input type="text" class="form-control" id="editorial" name="editorial"
                    value="{{ $editionBook->editorial }}">
            </div>


            <div class="mb-3">
                <label for="price" class="form-label">Precio</label>
                <input type="text" class="form-control" id="price" name="price" min="0" value="{{ $editionBook->price }}">
            </div>


            <button type="submit" class="btn btn-primary mb-3">Actualizar Libro</button>
            <a href="{{ route('books.list') }}" class="btn btn-danger mb-3">Cancelar</a>
        </form>
    </div>
@endsection
