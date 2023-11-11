@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h3>Funcionalidades de Administrador:</h3>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <a href="{{ route('user.management') }}">Gestión de Usuarios</a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{ route('book.management') }}">Gestión de Libros/Ediciones</a>
                        </li>
                        <li class="list-group-item">
                            <a href="{{ route('subadmin.management') }}">Gestión de Subadministradores</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
