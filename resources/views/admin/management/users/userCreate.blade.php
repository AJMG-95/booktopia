<!-- resources/views/admin/management/users/userCreate.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container mt-4 border rounded border-black">

        <h2 class="mt-3 ms-3">Crear Nuevo Usuario</h2>
        <form method="POST" action="{{ route('user.store') }}">
            @csrf

            <div class="form-group admin-form mb-3">
                <label for="nickname" class="col-form-label text-md-right">{{ __('Nickname') }}</label>

                <input id="nickname" type="text" class="form-control @error('nickname') is-invalid @enderror"
                    name="nickname" value="{{ old('nickname') }}" required autocomplete="nickname" autofocus>

                @error('nickname')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

            </div>

            <div class="form-group admin-form mb-3">
                <label for="name" class="col-form-label text-md-right">{{ __('Nombre') }}</label>

                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    value="{{ old('name') }}" required autocomplete="name">

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

            </div>

            <div class="form-group admin-form mb-3">
                <label for="surnames" class="col-form-label text-md-right">{{ __('Apellidos') }}</label>

                <input id="surnames" type="text" class="form-control @error('surnames') is-invalid @enderror"
                    name="surnames" value="{{ old('surnames') }}" required autocomplete="surnames">

                @error('surnames')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group admin-form mb-3">
                <label for="email" class="col-form-label text-md-right">{{ __('Email') }}</label>

                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email') }}" required autocomplete="email">

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>


            <div class="form-group admin-form mb-3">
                <label for="birth_date" class="col-form-label text-md-right">{{ __('Fecha de nacimiento') }}</label>

                <input id="birth_date" type="date" class="form-control @error('birth_date') is-invalid @enderror"
                    name="birth_date" value="{{ old('birth_date') }}" required autocomplete="birth_date">

                @error('birth_date')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group admin-form mb-3">
                <label for="country_id" class="col-form-label text-md-right">{{ __('Pais') }}</label>

                <select class="form-control" id="country_id" name="country_id">
                    <!-- Include options for countries -->
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->country_name }}</option>
                    @endforeach
                </select>
                @error('country_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group admin-form mb-3">
                <label for="biography" class=" col-form-label text-md-right">{{ __('Biografía') }}</label>


                <textarea id="biography" class="form-control @error('biography') is-invalid @enderror" name="biography"
                    autocomplete="biography"></textarea>

                @error('biography')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

            </div>

            <div class="form-group admin-form mb-3">
                <label for="password" class="col-form-label text-md-right">{{ __('Contraseña') }}</label>

                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" value="{{ old('password') }}" required autocomplete="password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

            </div>

            <!-- Repeat similar blocks for other form fields -->
            <button type="submit" class="btn btn-primary mb-3">
                {{ __('Crear Usuario') }}
            </button>

        </form>
    </div>
@endsection
