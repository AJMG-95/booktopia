@extends('layouts.app')

@section('content')
    <div class="container-fluid ms-0 me-0 px-4 py-3 mt-3">

        <div class="ms-3 mb-4 text-center p-2" style="background-color:rgba(247, 247, 247, 0.651)">
            <h1 class="display-4 fw-bold" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);">
                <img src="{{ asset('assets/images/logos/logo2.png') }}" alt="Logo" style="max-height: 10vh">
                <ins>
                    Gestón de subadministradores
                </ins>
            </h1>
        </div>

        <div class="mb-3 mx-5">
            <a href="{{ route('subadmins.create') }}" class="btn btn-primary me-3">Crear Subadmin</a>
            <a href="{{ route('home') }}" class="btn btn-primary">Volver</a>
        </div>

        <div class="table-responsive px-5">
            <table class="table table-bordered table-striped table-hover rounded">
                <thead class="thead-dark">
                    <tr>
                        <th></th>
                        <th>Nickname</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subadmins as $subadmin)
                        <tr>
                            <td class="text-center">{{ $subadmin->id }}</td>
                            <td>{{ $subadmin->nickname }}</td>
                            <td>{{ $subadmin->name }}</td>
                            <td>{{ $subadmin->email }}</td>
                            <td class="text-center">
                                <div class="btn-group" role="group" aria-label="User Actions">
                                    <a href="{{ route('subadmins.edit', $subadmin->id) }}"
                                        class="btn btn-primary  me-2">  <i class="bi bi-pencil"></i> </a>

                                    <form action="{{ route('subadmins.destroy', ['id' => $subadmin->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('¿Estás seguro de eliminar definitivamente este subadmin?')">Eliminar</button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
@endsection
