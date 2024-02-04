<!-- subadminCreate.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container-fluid ms-0 me-0 px-4 py-3 mt-3">
        <div class="ms-3 mb-4 text-center p-2" style="background-color:rgba(247, 247, 247, 0.651)">
            <h1 class="display-4 fw-bold" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);">
                <img src="{{ asset('assets/images/logos/logo2.png') }}" alt="Logo" style="max-height: 10vh" class="img-fluid">
                <ins>
                    Crear Nuevo Subadministrador
                </ins>
            </h1>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12 " style="min-width: 50vw; max-width:  80vw;">
                <div class="card border border-black " style="min-width: 50vw; ">
                    <div class="card-body ">
                        <form method="POST" action="{{ route('subadmins.store') }}">
                            @csrf

                            <!-- Campo Nick -->
                            <div class="mb-3">
                                <label for="nickname" class="form-label">{{ __('Nickname') }}</label>
                                <input id="nickname" type="text"
                                    class="border border-black form-control @error('nickname') is-invalid @enderror"
                                    name="nickname" value="{{ old('nickname') }}" required autocomplete="nickname"
                                    autofocus>
                                @error('nickname')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>


                            <!-- Campo Nombre -->
                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('Nombre') }}</label>
                                <input id="name" type="text"
                                    class="border border-black  form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" required autocomplete="name">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>


                            <!-- Campo Apellidos -->
                            <div class="mb-3">
                                <label for="surnames" class="form-label">{{ __('Apellidos') }}</label>
                                <input id="surnames" type="text"
                                    class="border border-black  form-control @error('surnames') is-invalid @enderror"
                                    name="surnames" value="{{ old('surnames') }}" required autocomplete="surnames">
                                @error('surnames')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>


                            <!-- Campo Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('Email') }}</label>
                                <input id="email" type="email"
                                    class="border border-black  form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>


                            <!-- Campo Contraseña -->
                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('Contraseña') }}</label>
                                <input id="password" type="password"
                                    class="border border-black  form-control @error('password') is-invalid @enderror"
                                    name="password" required autocomplete="new-password">
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>


                            <!-- Campo Rol -->
                            <div class="mb-3 " style="display: none;">
                                <label for="role" class="form-label">Rol</label>
                                <select name="role" id="role" class="form-control" required disabled>
                                    @foreach ($roles as $role)
                                        @if ($role->id !== 2)
                                            <option value="{{ $role->id }}">{{ $role->rol_name }}</option>
                                        @else
                                            <option value="{{ $role->id }}" selected>{{ $role->rol_name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('role')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3 d-flex flex-row justify-content-around flex-wrap">
                                <button type="submit" class="btn btn-primary text-wrap mt-3">Crear Subadmin</button>
                                <a href="{{ route('subadmins.list') }}" class="btn btn-danger  mt-3">{{ __('Cancelar') }}</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
