<!-- resources/views/admin/management/books/bookCreate.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container-fluid ms-0 me-0 px-4 py-3 mt-3">

        <div class="ms-3 mb-4 text-center p-2" style="background-color:rgba(247, 247, 247, 0.651)">
            <h1 class="display-4 fw-bold" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);">
                <img src="{{ asset('assets/images/logos/logo2.png') }}" alt="Logo" style="max-height: 10vh">
                <ins>
                    Crear Nuevo Libro
                </ins>
            </h1>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12 " style="min-width: 50vw; max-width:  80vw;">
                <div class="card border border-black " style="min-width: 50vw; ">
                    <div class="card-body ">
                        <form action="{{ route('books.store') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <p class="form-label">Opciones de libro</p>

                                <input type="checkbox" class="border border-black form-check-input" id="self_published"
                                    name="self_published" value="1" {{ old('self_published') ? 'checked' : '' }}>
                                <label for="self_published" class="form-label me-3">{{ __('Autoedición') }}</label>

                                <input type="checkbox" class="border border-black form-check-input" id="for_adults"
                                    name="for_adults" value="1" {{ old('for_adults') ? 'checked' : '' }}>
                                <label for="for_adults" class="form-label  me-3">{{ __('Libro para adultos') }}</label>

                                <input type="checkbox" class="border border-black form-check-input" id="visible"
                                    name="visible" value="1" {{ old('visible') ? 'checked' : '' }}>
                                <label for="visible" class="form-label">{{ __('Visible') }}</label>
                            </div>

                            <div class="mb-3">
                                <label for="title" class="form-label">{{ __('Título') }}</label>
                                <input id="title" type="text"
                                    class="border border-black  form-control @error('title') is-invalid @enderror"
                                    name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>
                                @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="cover" class="form-label">{{ __('Portada') }}</label>
                                <input id="cover" type="file"
                                    class="border border-black  form-control @error('cover') is-invalid @enderror"
                                    name="cover" value="{{ old('cover') }}" required autocomplete="cover" autofocus>
                                @error('cover')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="document" class="form-label">{{ __('Documento (PDF)') }}</label>
                                <input id="document" type="file"
                                    class="border border-black  form-control @error('document') is-invalid @enderror"
                                    name="document" value="{{ old('document') }}" required autocomplete="document"
                                    autofocus>
                                @error('document')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label">{{ __('Autores') }}</label>
                                <div style="max-height: 100px; overflow-y: auto;"
                                    class="bg-white rounded border border-black px-2 py-1">
                                    @foreach ($authors as $author)
                                        <div class="form-check">
                                            <input class="form-check-input text-black border-black  me-1" type="checkbox"
                                                id="author_{{ $author->id }}" name="authors[]"
                                                value="{{ $author->id }}">
                                            <label class="form-check-label text-black" for="author_{{ $author->id }}">
                                                {{ $author->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('Géneros') }}</label>
                                <div style="max-height: 100px; overflow-y: auto;"
                                    class="bg-white rounded border border-black px-2 py-1">
                                    @foreach ($genres as $genre)
                                        <div class="form-check">
                                            <input class="form-check-input text-black border-black me-1" type="checkbox"
                                                id="genre_{{ $genre->id }}" name="genres[]"
                                                value="{{ $genre->id }}">
                                            <label class="form-check-label text-black" for="genre_{{ $genre->id }}">
                                                {{ $genre->genre_name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('Idioma') }}</label>
                                <select class="form-select border border-black" id="language_id" name="language_id">
                                    @foreach ($languages as $language)
                                        <option value="{{ $language->id }}"
                                            {{ old('language_id') == $language->id ? 'selected' : '' }}>
                                            {{ $language->language }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="mb-3">
                                <label for="short_description" class="form-label">{{ __('Descripción Corta') }}</label>
                                <textarea id="short_description"
                                    class="border border-black  form-control @error('short_description') is-invalid @enderror"
                                    name="short_description" autocomplete="short_description"></textarea>
                                @error('short_description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">{{ __('Descripción') }}</label>
                                <textarea id="description" class="border border-black  form-control @error('description') is-invalid @enderror"
                                    name="description" autocomplete="description"></textarea>
                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="price" class="form-label">{{ __('Precio') }}</label>
                                <input id="price" type="text"
                                    class="border border-black  form-control @error('price') is-invalid @enderror"
                                    name="price" value="{{ old('price') }}" required autocomplete="price" autofocus
                                    min="0" max="9999" placeholder="formato: x.xxx,xx">
                                @error('price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3 d-flex flex-row justify-content-around flex-wrap">
                                <button type="submit"
                                    class="btn btn-primary text-wrap mt-3">{{ __('Crear Libro') }}</button>
                                <a href="{{ route('books.list') }}" class="btn btn-danger  mt-3">{{ __('Cancelar') }}</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
