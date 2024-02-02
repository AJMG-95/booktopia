@extends('layouts.app')

@section('content')
    <div class="container-fluid ms-0 me-0 px-4 py-3 mt-3">

        <div class="ms-3 mb-4 text-center p-2" style="background-color:rgba(247, 247, 247, 0.651)">
            <h1 class="display-4 fw-bold" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);">
                <img src="{{ asset('assets/images/logos/logo2.png') }}" alt="Logo" style="max-height: 10vh">
                <ins>Editar Subadministrador:</ins> {{ $subadmin->nickname }}
            </h1>
        </div>

        <div class="row justify-content-center ">
            <div class="col-md-12 " style="min-width: 50vw; max-width:  80vw;">
                <div class="card border border-black overflow-x-scroll" style="min-width: 50vw; ">
                    <div class="card-body ">
                        <form action="{{ route('subadmins.update', $subadmin->id) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="mb-3">
                                <label for="nickname" class="form-label">Nickname</label>
                                <input type="text" class="form-control" id="nickname" name="nickname"
                                    value="{{ old('nickname', $subadmin->nickname) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name', $subadmin->name) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="surnames" class="form-label">Apellidos</label>
                                <input type="text" class="form-control" id="surnames" name="surnames"
                                    value="{{ old('surnames', $subadmin->surnames) }}" required>
                            </div>

                            <!-- Agrega los demás campos del modelo User -->

                            <div class="mb-3" style="display: none;">
                                <label for="role_id" class="form-label">Rol</label>
                                <select name="role_id" id="role_id" class="form-control" required>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ old('role_id', $subadmin->role->id) == $role->id ? 'selected' : '' }}>
                                            {{ $role->rol_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
