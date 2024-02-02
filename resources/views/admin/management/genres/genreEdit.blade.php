<!-- resources/views/admin/management/genres/genreEdit.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container-fluid ms-0 me-0 px-4 py-3 mt-3">

        <div class="ms-3 mb-4 text-center p-2" style="background-color:rgba(247, 247, 247, 0.651)">
            <h1 class="display-4 fw-bold" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);">
                <img src="{{ asset('assets/images/logos/logo2.png') }}" alt="Logo" style="max-height: 10vh">
                <ins>Editar Genero:</ins> {{ $genre->genre_name }}
            </h1>
        </div>

        <div class="row justify-content-center ">
            <div class="col-md-12 " style="min-width: 50vw; max-width:  80vw;">
                <div class="card border border-black overflow-x-scroll" style="min-width: 50vw; ">
                    <div class="card-body ">
                        <form method="post" action="{{ route('genres.update', $genre->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('patch')


                            <div class="mb-3">
                                <label for="genre_name" class="form-label">{{ __('Género') }}</label>
                                <input id="genre_name" type="text"
                                    class="border border-black border border-black form-control @error('genre_name') is-invalid @enderror"
                                    name="genre_name" value="{{ old('genre_name', $genre->genre_name) }}" required
                                    autocomplete="genre_name" autofocus>
                                @error('genre_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="description" class="form-label">{{ __('Descripción') }}</label>

                                <textarea id="description" class="border border-black form-control @error('description') is-invalid @enderror"
                                    name="description" autocomplete="description">{{ old('description', $genre->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                            <div class="mb-3">
                                <p class="form-label">Imagen actual</p>
                                @if ($genre->img_url)
                                    <img src="{{ asset('storage/' . $genre->img_url) }}" alt="Imagen actual del Género"
                                        style="max-width: 7vw">
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="img_url" class="form-label">{{ __('Cambiar Imagen') }}</label>
                                <input id="img_url" type="file"
                                    class="border border-black  form-control @error('img_url') is-invalid @enderror"
                                    name="img_url" value="{{ old('img_url') }}" autocomplete="img_url" autofocus>
                                @error('img_url')
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
                                    <a href="{{ route('genres.list') }}" class="btn btn-danger">
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
