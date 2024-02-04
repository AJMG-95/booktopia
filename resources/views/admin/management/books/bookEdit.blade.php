@extends('layouts.app')

@section('content')
    <div class="container-fluid ms-0 me-0 px-4 py-3 mt-3">

        <div class="ms-3 mb-4 text-center p-2" style="background-color:rgba(247, 247, 247, 0.651)">
            <h1 class="display-4 fw-bold" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);">
                <img src="{{ asset('assets/images/logos/logo2.png') }}" alt="Logo" style="max-height: 10vh" class="img-fluid">
                <ins>Editar Libro:</ins> {{ $editionBook->title }}
            </h1>
        </div>

        <div class="row justify-content-center ">
            <div class="col-md-12 " style="min-width: 50vw; max-width:  80vw;">
                <div class="card border border-black" style="min-width: 50vw; ">
                    <div class="card-body ">
                        <form action="{{ route('books.update', $editionBook->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="mb-3">
                                <p class="form-label">Opciones de libro</p>
                                <div class="d-flex">

                                    <div class="mb-3 form-check">
                                        <input type="hidden" name="self_published" value="0">
                                        <!-- Hidden input for self_published -->
                                        <input type="checkbox" class="form-check-input  border border-black" id="self_published"
                                            name="self_published" value="1"
                                            {{ $editionBook->self_published ? 'checked' : '' }}>
                                        <label for="self_published"
                                            class="form-check-label me-3">{{ __('Autoedición') }}</label>
                                    </div>

                                    <div class="mb-3 form-check">
                                        <input type="hidden" name="for_adults" value="0">
                                        <!-- Hidden input for for_adults -->
                                        <input type="checkbox" class="form-check-input  border border-black" id="for_adults" name="for_adults"
                                            value="1" {{ $editionBook->for_adults ? 'checked' : '' }}>
                                        <label for="for_adults"
                                            class="form-check-label me-3">{{ __('Libro para adultos') }}</label>
                                    </div>


                                    <div class="mb-3 form-check">
                                        <input type="hidden" name="visible" value="0">
                                        <!-- Hidden input for visible -->
                                        <input type="checkbox" class="form-check-input  border border-black" id="visible" name="visible"
                                            value="1" {{ $editionBook->visible ? 'checked' : '' }}>
                                        <label for="visible" class="form-check-label">{{ __('Visible') }}</label>
                                    </div>
                                </div>


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
                                    name="document" value="{{ old('document') }}" autocomplete="document" autofocus>
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
                                                value="{{ $author->id }}"
                                                {{ $editionBook->authors->contains('id', $author->id) ? 'checked' : '' }}>
                                            <label class="form-check-label text-black" for="author_{{ $author->id }}">
                                                {{ $author->name }} {{ $author->surnames }}
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
                                                value="{{ $genre->id }}"
                                                {{ $editionBook->genres->contains('id', $genre->id) ? 'checked' : '' }}>
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
                                            {{ $language->id == $editionBook->language_id ? 'selected' : '' }}>
                                            {{ $language->language }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>



                            <div class="mb-3">
                                <label for="short_description" class="form-label">{{ __('Descripción Corta') }}</label>
                                <textarea id="short_description"
                                    class="border border-black  form-control @error('short_description') is-invalid @enderror"
                                    name="short_description" autocomplete="short_description">{{ $editionBook->short_description }}</textarea>
                                @error('short_description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">{{ __('Descripción') }}</label>
                                <textarea id="description" class="border border-black  form-control @error('description') is-invalid @enderror"
                                    name="description" autocomplete="description">{{ $editionBook->description }}</textarea>
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
                                    name="price" value="{{ number_format($editionBook->price, 2, ',', '.') }}" required
                                    autocomplete="price" autofocus min="0" max="9999"
                                    placeholder="formato: x.xxx,xx">
                                @error('price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
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
