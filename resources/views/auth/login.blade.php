<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>


</head>

<body>
    @extends('layouts.app')

    @section('content')
        <div class="container mt-5 pt-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Login') }}</div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('login') }}" id="loginForm">
                                @csrf

                                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <div class="row mb-3">
                                    <label for="email"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" autocomplete="email" autofocus>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Contraseña') }}</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            autocomplete="current-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                                {{ old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label" for="remember">
                                                {{ __('Recuerdame') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class=" mb-0 text-center">
                                    <div class="d-flex justify-content-center align-items-center text-center">
                                        <div class="me-1 mb-2 ">
                                            <button type="submit" class="btn btn-primary btn-block" style="width: 5.3vw">
                                                {{ __('Login') }}
                                            </button>
                                        </div>
                                        <div class="ms-1 mb-2 ">
                                            <a class="btn btn-danger btn-block" href="{{ route('welcome') }}"
                                                style="width: 5.3vw">
                                                {{ __('Cancelar') }}
                                            </a>
                                        </div>
                                    </div>
                                    <div class=" mt-2">
                                        <a class="btn btn-secondary btn-block" href="{{ route('register') }}">
                                            {{ __('Registrarse') }}
                                        </a>
                                    </div>
                                </div>



                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const loginForm = document.getElementById('loginForm');

                loginForm.addEventListener('submit', function(event) {
                    let valid = true;

                    // Validar email
                    const emailInput = document.getElementById('email');
                    const emailValue = emailInput.value.trim();
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                    if (emailValue === '' || !emailRegex.test(emailValue)) {
                        valid = false;
                        alert('Ingrese un correo electrónico válido.');
                        event.preventDefault(); // Evita que se envíe el formulario
                    }

                    // Validar contraseña
                    const passwordInput = document.getElementById('password');
                    const passwordValue = passwordInput.value.trim();

                    if (passwordValue === '') {
                        valid = false;
                        alert('Ingrese una contraseña.');
                        event.preventDefault(); // Evita que se envíe el formulario
                    }
                });
            });
        </script>
    @endsection
</body>


</html>
