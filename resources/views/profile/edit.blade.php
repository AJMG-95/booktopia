{{-- resources/views/profile/edit.blade.php --}}
@extends('layouts.app')  {{-- Asume que tienes una plantilla base llamada 'app.blade.php' --}}

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Editar Perfil') }}</div>

                    <div class="card-body">
                        <!-- Formulario para actualizar la información del perfil -->
                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="form-group mb-3">
                                <label for="nickname">{{ __('Nickname') }}</label>
                                <input id="nickname" type="text" class="form-control" name="nickname" value="{{ old('nickname', Auth::user()->nickname) }}" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="profile_img">{{ __('Foto de Perfil') }}</label>
                                <input id="profile_img" type="file" class="form-control" name="profile_img">
                            </div>

                            <div class="form-group mb-3">
                                <label for="email">{{ __('Correo Electrónico') }}</label>
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                {{ __('Guardar Cambios del Perfil') }}
                            </button>
                        </form>
                    </div>

                    <div class="card-body mt-4">
                        <!-- Formulario para cambiar la contraseña -->
                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PATCH')

                            <input type="hidden" name="update_type" value="password"> {{-- Campo oculto para identificar la acción --}}

                            <div class="form-group mb-3">
                                <label for="current_password">{{ __('Contraseña Actual') }}</label>
                                <input id="current_password" type="password" class="form-control" name="current_password" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="password">{{ __('Nueva Contraseña') }}</label>
                                <input id="password" type="password" class="form-control" name="password" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="password_confirmation">{{ __('Confirmar Nueva Contraseña') }}</label>
                                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                {{ __('Cambiar Contraseña') }}
                            </button>
                        </form>
                    </div>

                    <div class="card-footer">
                        <div class="p-4 sm:p-8 shadow sm:rounded-lg">
                            <div class="max-w-xl">
                                <a href="{{ route('profile.index') }}" class="btn btn-danger ">Cancelar Edición</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

