@extends('layouts.app')

@section('content')
    <div class="container-fluid ms-0 me-0 px-4 py-3 mt-3">

        <div class="ms-3 mb-4 text-center p-2" style="background-color:rgba(247, 247, 247, 0.651)">
            <h1 class="display-4 fw-bold" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);">
                <img src="{{ asset('assets/images/logos/logo2.png') }}" alt="Logo" style="max-height: 10vh">
                <ins>
                    Crear Nuevo Autor
                </ins>
            </h1>
        </div>

        <!-- Mostrar mensajes de éxito o error aquí -->
        <div class="row justify-content-center">
            <div class="col-md-12 " style="min-width: 50vw; max-width:  80vw;">
                <div class="card border border-black " style="min-width: 50vw; ">
                    <div class="card-body ">
                        <form action="{{ route('authors.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf


                            <div class="mb-3">
                                <label for="nickname" class="form-label">{{ __('Nickname') }}</label>
                                <input id="nickname" type="text" class="border border-black  form-control @error('nickname') is-invalid @enderror"
                                    name="nickname" value="{{ old('nickname') }}" required autocomplete="nickname" autofocus>
                                @error('nickname')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('Nombre') }}</label>
                                <input id="name" type="text" class="border border-black  form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" required autocomplete="name">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="surnames" class="form-label">{{ __('Apellidos') }}</label>
                                <input id="surnames" type="text" class="border border-black  form-control @error('surnames') is-invalid @enderror"
                                    name="surnames" value="{{ old('surnames') }}" required autocomplete="surnames">
                                @error('surnames')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="birth_at" class="form-label">{{ __('Fecha de nacimiento') }}</label>
                                <input id="birth_at" type="date" class="border border-black  form-control @error('birth_at') is-invalid @enderror"
                                    name="birth_at" value="{{ old('birth_at') }}" required autocomplete="birth_at">
                                @error('birth_at')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="country_id" class="form-label">{{ __('País') }}</label>
                                <select class="border border-black  form-control" id="country_id" name="country_id">
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                                    @endforeach
                                </select>
                                @error('country_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="biography" class="form-label">{{ __('Biografía') }}</label>
                                <textarea id="biography" class="border border-black  form-control @error('biography') is-invalid @enderror" name="biography"
                                    autocomplete="biography"></textarea>
                                @error('biography')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="photo" class="form-label">{{ __('Biografía') }}</label>
                                <input id="photo" type="file" class="border border-black  form-control @error('photo') is-invalid @enderror"
                                name="photo" value="{{ old('photo') }}" required autocomplete="photo">
                                @error('photo')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>


                            <div class="mb-3 d-flex flex-row justify-content-around flex-wrap">
                                <button type="submit" class="btn btn-primary text-wrap mt-3">{{ __('Crear Autor') }}</button>
                                <a href="{{ route('authors.list') }}" class="btn btn-danger  mt-3">{{ __('Cancelar') }}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
