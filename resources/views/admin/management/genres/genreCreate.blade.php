<!-- resources/views/admin/management/genres/genreCreate.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container-fluid ms-0 me-0 px-4 py-3 mt-3">

        <div class="ms-3 mb-4 text-center p-2" style="background-color:rgba(247, 247, 247, 0.651)">
            <h1 class="display-4 fw-bold" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);">
                <img src="{{ asset('assets/images/logos/logo2.png') }}" alt="Logo" style="max-height: 10vh">
                <ins>
                    Crear Nuevo Género
                </ins>
            </h1>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12 " style="min-width: 50vw; max-width:  80vw;">
                <div class="card border border-black " style="min-width: 50vw; " >
                    <div class="card-body ">
                        <form action="{{ route('genres.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="genre_name" class="form-label">{{ __('Nombre del Género') }}</label>
                                <input id="genre_name" type="text" class="border border-black  form-control @error('genre_name') is-invalid @enderror"
                                    name="genre_name" value="{{ old('genre_name') }}" required autocomplete="genre_name" autofocus>
                                @error('genre_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">{{ __('description') }}</label>
                                <textarea id="description" type="text" class="border border-black  form-control @error('description') is-invalid @enderror"
                                    name="description" value="{{ old('description') }}" required autocomplete="description" autofocus rows="3">
                                </textarea>
                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="img_url" class="form-label">Imagen del Género</label>
                                <input type="file" class="form-control" id="img_url" name="img_url">
                            </div>

                            <div class="mb-3 d-flex flex-row justify-content-around flex-wrap">
                                <button type="submit" class="btn btn-primary">Guardar Género</button>
                                <a href="{{ route('genres.list') }}" class="btn btn-danger ">Cancelar</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
