<!-- subadminCreate.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Crear Subadmin</h2>

        <!-- Formulario para crear subadmin -->
        <form method="POST" action="{{ route('subadmins.store') }}">
            @csrf

            <!-- Campo Nick -->
            <div class="form-group">
                <label for="nickname">Nick:</label>
                <input type="text" name="nickname" id="nickname" class="form-control" required>
                @error('nickname')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Campo Nombre -->
            <div class="form-group">
                <label for="name">Nombre:</label>
                <input type="text" name="name" id="name" class="form-control" required>
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Campo Apellidos -->
            <div class="form-group">
                <label for="surnames">Apellidos:</label>
                <input type="text" name="surnames" id="surnames" class="form-control" required>
                @error('surnames')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Campo Email -->
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" class="form-control" required>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Campo Contraseña -->
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" name="password" id="password" class="form-control" required>
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Campo Rol -->
            <div class="mb-3">
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

            <!-- Otros campos del formulario -->

            <button type="submit" class="btn btn-success">Crear Subadmin</button>
        </form>
    </div>
@endsection
