@extends('layouts.app')

@section('content')
    <div class="container-fluid ms-0 me-0 px-4 py-3 mt-3">

        <div class="ms-3 mb-4 text-center p-2" style="background-color:rgba(247, 247, 247, 0.651)">
            <h1 class="display-4 fw-bold" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);">
                <img src="{{ asset('assets/images/logos/logo2.png') }}" alt="Logo" style="max-height: 10vh">
                <ins>Editar Libro:</ins> {{ $editionBook->title }}
            </h1>
        </div>

        <div class="row justify-content-center ">
            <div class="col-md-12 " style="min-width: 50vw; max-width:  80vw;">
                <div class="card border border-black overflow-x-scroll" style="min-width: 50vw; ">
                    <div class="card-body ">
                        <form action="{{ route('books.update', $editionBook->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')


                            <div class="mb-3">
                                <p class="form-label">Opciones de libro</p>

                                <input type="checkbox" class="border border-black form-check-input" id="self_published"
                                    name="self_published" value="1"
                                    {{ $editionBook->self_published ? 'checked' : '' }}>
                                <label for="self_published" class="form-label me-3">{{ __('Autoedición') }}</label>

                                <input type="checkbox" class="border border-black form-check-input" id="for_adults"
                                    name="for_adults" value="1" {{ $editionBook->for_adults ? 'checked' : '' }}>
                                <label for="for_adults" class="form-label  me-3">{{ __('Libro para adultos') }}</label>

                                <input type="checkbox" class="border border-black form-check-input" id="visible"
                                    name="visible" value="1" {{ $editionBook->visible ? 'checked' : '' }}>
                                <label for="visible" class="form-label">{{ __('Visible') }}</label>
                            </div>


                            <div class="mb-3">
                                <label for="title" class="form-label">{{ __('Título') }}</label>
                                <input id="title" type="text"
                                    class="border border-black  form-control @error('title') is-invalid @enderror"
                                    name="title" value="{{ $editionBook->title }}" required autocomplete="title"
                                    autofocus>
                                @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <p class="form-label">Imagen actual</p>
                                @if (isset($editionBook) && $editionBook->cover)
                                    <img src="{{ asset('storage/' . $editionBook->cover) }}" alt="Imagen actual del Género"
                                        style="max-width: 7vw">
                                @else
                                    No imagen
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="cover" class="form-label">{{ __('Cambiar Portada') }}</label>
                                <input id="cover" type="file"
                                    class="border border-black  form-control @error('cover') is-invalid @enderror"
                                    name="cover" value="{{ old('cover') }}" autocomplete="cover" autofocus>
                                @error('cover')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>




                            <div class="mb-3">
                                <label for="document" class="form-label">{{ __('Nuevo Documento (PDF)') }}</label>
                                <input id="document" type="file"
                                    class="border border-black  form-control @error('document') is-invalid @enderror"
                                    name="document" value="{{ old('document') }}"  autocomplete="document"
                                    autofocus>
                                @error('document')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
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
                                            {{ $language->language }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="short_description" class="form-label">Descripción Corta</label>
                                <textarea class="form-control" id="short_description" name="short_description">{{ $editionBook->short_description }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Descripción</label>
                                <textarea class="form-control" id="description" name="description">{{ $editionBook->description }}</textarea>
                            </div>


                            <div class="mb-3">
                                <label for="price" class="form-label">Precio</label>
                                <input type="text" class="form-control" id="price" name="price" min="0"
                                    value="{{ $editionBook->price }}">
                            </div>


                            <div class="form-group row mb-3 ms-0 me-0 text-center">
                                <div class="col-md-6 ">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Actualizar') }}
                                    </button>
                                </div>
                                <div class="col-md-6 ">
                                    <a href="{{ route('books.list') }}" class="btn btn-danger">
                                        {{ __('Cancelar') }}
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
