@extends('layouts.app')

@section('content')
    <div class="container adminContainer admin">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card adminCard">
                    <div class="card-header admin-card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body admin-card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <h3 class="admin-h3">Funcionalidades de Administrador:</h3>
                        <ul class="list-group admin-list-group">
                            <li class="list-group-item admin-list-group-item">
                                <a class="admin-a " href="{{ route('users.list') }}">{{ __('Gestión de Usuarios') }}</a>
                            </li>
                            <li class="list-group-item admin-list-group-item">
                                <a class="admin-a " href="{{ route('books&editions.index') }}">{{ __('Gestión de Libros/Ediciones') }}</a>
                            </li>
                            @if (Auth::user()->isAdmin())
                            <li class="list-group-item admin-list-group-item">
                                <a class="admin-a " href="{{ route('subadmins.list') }}">{{ __('Gestión de Subadministradores') }}</a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
