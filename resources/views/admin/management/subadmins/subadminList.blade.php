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
            @foreach($subadmins as $subadmin)
                <tr>
                    <td>{{ $subadmin->id }}</td>
                    <td>{{ $subadmin->name }}</td>
                    <td>{{ $subadmin->email }}</td>
                    <td>
                        <a href="{{ route('subadmins.update', $subadmin->id) }}" class="btn btn-warning">Editar</a>
                        <a href="{{ route('subadmins.demote', $subadmin->id) }}" class="btn btn-info">Degradar a Usuario</a>
                        <form action="{{ route('subadmins.destroy', $subadmin->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
