{{-- resources.views.admin.management.authors.authorEdit.blade.php --}}

@extends('layouts.app')

@section('content')
    <div class="container-fluid ms-0 me-0 px-4 py-3 mt-3">

        <div class="ms-3 mb-4 text-center p-2" style="background-color:rgba(247, 247, 247, 0.651)">
            <h1 class="display-4 fw-bold" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);">
                <img src="{{ asset('assets/images/logos/logo2.png') }}" alt="Logo" style="max-height: 10vh" class="img-fluid">
                <ins>Editar Autor:</ins> {{ $author->nickname }}
            </h1>
        </div>

        <div class="row justify-content-center ">
            <div class="col-md-12 " style="min-width: 50vw; max-width:  80vw;">
                <div class="card border border-black overflow-x-scroll" style="min-width: 50vw; ">
                    <div class="card-body ">
                        <form action="{{ route('authors.update', ['id' => $author->id]) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')


                            <div class="mb-3">
                                <label for="nickname" class="form-label">{{ __('Nickname') }}</label>
                                <input id="nickname" type="text"
                                    class="border border-black border border-black form-control @error('nickname') is-invalid @enderror"
                                    name="nickname" value="{{ old('nickname', $author->nickname) }}" required
                                    autocomplete="nickname" autofocus>
                                @error('nickname')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('Nombre') }}</label>
                                <input id="name" type="text"
                                    class="border border-black form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name', $author->name) }}" required autocomplete="name">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="surnames" class="form-label">{{ __('Apellidos') }}</label>
                                <input id="surnames" type="text"
                                    class="border border-black form-control @error('surnames') is-invalid @enderror"
                                    name="surnames" value="{{ old('surnames', $author->surnames) }}" required
                                    autocomplete="surnames">
                                @error('surnames')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>



                            <div class="mb-3">
                                <label for="birth_at" class="form-label">{{ __('Fecha de nacimiento') }}</label>
                                <input id="birth_at" type="date"
                                    class="border border-black form-control @error('birth_at') is-invalid @enderror"
                                    name="birth_at" value="{{ old('birth_at', $author->birth_at) }}"
                                    autocomplete="birth_at">
                                @error('birth_at')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="country_id" class="form-label">{{ __('País') }}</label>
                                <select class="border border-black form-control" id="country_id" name="country_id">
                                    <!-- Include options for countries -->
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}"
                                            {{ old('country_id', $author->country_id) == $country->id ? 'selected' : '' }}>
                                            {{ $country->country_name }}
                                        </option>
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

                                <textarea id="biography" class="border border-black form-control @error('biography') is-invalid @enderror"
                                    name="biography" autocomplete="biography">{{ old('biography', $author->biography) }}</textarea>
                                @error('biography')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            <div class="mb-3">
                                <label for="photo" class="form-label">{{ __('Foto') }}</label>
                                <input id="photo" type="file" class="border border-black  form-control @error('photo') is-invalid @enderror"
                                name="photo" value="{{ old('photo') }}"  autocomplete="photo" autofocus>
                                @error('photo')
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
                                    <a href="{{ route('authors.list') }}" class="btn btn-danger">
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
