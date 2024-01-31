@extends('layouts.app')

@section('content')
<div class="container-fluid ms-0 me-0 px-3 py-3 mt-2">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Registro') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf


                        <div class="row mb-3">
                            <label for="nickname" class="col-md-4 col-form-label text-md-end">{{ __('Nickname') }}</label>

                            <div class="col-md-6">
                                <input id="nickname" type="text" class="form-control @error('nickname') is-invalid @enderror" name="nickname" value="{{ old('nickname') }}" required autocomplete="nickname" autofocus>

                                @error('nickname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Nombre') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="surnames" class="col-md-4 col-form-label text-md-end">{{ __('Apellidos') }}</label>

                            <div class="col-md-6">
                                <input id="surnames" type="text" class="form-control @error('surnames') is-invalid @enderror" name="surnames" value="{{ old('surnames') }}" required autocomplete="surnames" autofocus>

                                @error('surnames')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="birth_date" class="col-md-4 col-form-label text-md-end">{{ __('Fecha de nacimiento') }}</label>

                            <div class="col-md-6">
                                <input id="birth_date" type="date" class="form-control @error('birth_date') is-invalid @enderror" name="birth_date" value="{{ old('birth_date') }}" required>

                                @error('birth_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="country_id" class="col-md-4 col-form-label text-md-end">{{ __('País') }}</label>

                            <div class="col-md-6">
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
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Contraseña') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirmar contraseña') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class=" mb-0 text-center">
                            <div class="d-flex justify-content-center align-items-center text-center">
                                <div class="me-1 mb-2 ">
                                    <button type="submit" class="btn btn-primary btn-block" style="min-width: 6.2vw">
                                        {{ __('Registrarse') }}
                                    </button>
                                </div>
                                <div class="ms-1 mb-2 ">
                                    <a class="btn btn-danger btn-block" href="{{ route('welcome') }}" style="min-width: 6.2vw">
                                        {{ __('Cancelar') }}
                                    </a>
                                </div>
                            </div>
                            <div class=" mt-2">
                                <a class="btn btn-info btn-block" href="{{ route('login') }}" style="min-width: 5.3vw">
                                    {{ __('Login') }}
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
        const registerForm = document.querySelector('#registerForm');

        registerForm.addEventListener('submit', function(event) {
            let valid = true;

            // Validar nickname
            const nicknameInput = document.getElementById('nickname');
            const nicknameValue = nicknameInput.value.trim();

            if (nicknameValue === '') {
                valid = false;
                alert('Ingrese un nickname.');
                event.preventDefault(); // Evita que se envíe el formulario
            }

            // Validar name
            const nameInput = document.getElementById('name');
            const nameValue = nameInput.value.trim();

            if (nameValue === '') {
                valid = false;
                alert('Ingrese su nombre.');
                event.preventDefault(); // Evita que se envíe el formulario
            }

            // Validar surnames
            const surnamesInput = document.getElementById('surnames');
            const surnamesValue = surnamesInput.value.trim();

            if (surnamesValue === '') {
                valid = false;
                alert('Ingrese sus apellidos.');
                event.preventDefault(); // Evita que se envíe el formulario
            }

            // Validar email
            const emailInput = document.getElementById('email');
            const emailValue = emailInput.value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (emailValue === '' || !emailRegex.test(emailValue)) {
                valid = false;
                alert('Ingrese un correo electrónico válido.');
                event.preventDefault(); // Evita que se envíe el formulario
            }

            // Validar birth_date
            const birthDateInput = document.getElementById('birth_date');
            const birthDateValue = birthDateInput.value.trim();

            if (birthDateValue === '') {
                valid = false;
                alert('Ingrese su fecha de nacimiento.');
                event.preventDefault(); // Evita que se envíe el formulario
            }

            // Validar country_id
            const countryIdInput = document.getElementById('country_id');
            const countryIdValue = countryIdInput.value.trim();

            if (countryIdValue === '') {
                valid = false;
                alert('Seleccione su país.');
                event.preventDefault(); // Evita que se envíe el formulario
            }

            // Validar password
            const passwordInput = document.getElementById('password');
            const passwordValue = passwordInput.value.trim();

            if (passwordValue === '') {
                valid = false;
                alert('Ingrese una contraseña.');
                event.preventDefault(); // Evita que se envíe el formulario
            } else if (passwordValue.length < 8) {
                valid = false;
                alert('La contraseña debe tener al menos 8 caracteres.');
                event.preventDefault(); // Evita que se envíe el formulario
            }

            // Validar confirmación de contraseña
            const passwordConfirmInput = document.getElementById('password-confirm');
            const passwordConfirmValue = passwordConfirmInput.value.trim();

            if (passwordConfirmValue === '') {
                valid = false;
                alert('Confirme su contraseña.');
                event.preventDefault(); // Evita que se envíe el formulario
            }

            // Validar que las contraseñas coincidan
            if (passwordValue !== passwordConfirmValue) {
                valid = false;
                alert('Las contraseñas no coinciden.');
                event.preventDefault(); // Evita que se envíe el formulario
            }

            // Si todas las validaciones son exitosas, el formulario se enviará normalmente
        });
    });
</script>
@endsection
