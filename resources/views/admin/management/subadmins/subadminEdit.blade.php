@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Editar Subadmin</h2>

        <!-- Mostrar mensajes de éxito o error aquí -->

        <form action="{{ route('subadmins.update', $subadmin->id) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <label for="nickname" class="form-label">Nickname</label>
                <input type="text" class="form-control" id="nickname" name="nickname" value="{{ old('nickname', $subadmin->nickname) }}" required>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $subadmin->name) }}" required >
            </div>

            <div class="mb-3">
                <label for="surnames" class="form-label">Apellidos</label>
                <input type="text" class="form-control" id="surnames" name="surnames" value="{{ old('surnames', $subadmin->surnames) }}" required >
            </div>

            <!-- Agrega los demás campos del modelo User -->

            <div class="mb-3" style="display: none;">
                <label for="role_id" class="form-label">Rol</label>
                <select name="role_id" id="role_id" class="form-control" required>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role_id', $subadmin->role->id) == $role->id ? 'selected' : '' }}>
                            {{ $role->rol_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </form>
    </div>
@endsection
