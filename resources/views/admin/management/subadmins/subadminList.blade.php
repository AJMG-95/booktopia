@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Subadmin Management</h2>

        <!-- Mostrar mensajes de éxito o error aquí -->

        <div class="mb-3">
            <a href="{{ route('subadmins.create') }}" class="btn btn-success">Crear Subadmin</a>
        </div>

        <table class="table">
            <caption>Control de Subadministradores</caption>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subadmins as $subadmin)
                    <tr>
                        <td>{{ $subadmin->id }}</td>
                        <td>{{ $subadmin->name }}</td>
                        <td>{{ $subadmin->email }}</td>
                        <td>
                            {{-- * <a href="{{ route('subadmins.edit', $subadmin->id) }}" class="btn btn-warning">Editar</a> --}}
                            <a href="{{ route('subadmins.demote', $subadmin->id) }}" class="btn btn-info">
                                <i class="bi bi-person-down"></i> &nbsp; Degradar
                            </a>
                            <a href="{{ route('subadmins.destroy', $subadmin->id) }}" class="btn btn-danger"
                                onclick="return confirm('¿Estás seguro de eliminar definitivamente este subadmin?')">
                                <i class="bi bi-trash3"></i> &nbsp; Borrar
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
