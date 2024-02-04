@extends('layouts.app')

@section('content')
    <div class="container-fluid ms-0 me-0 px-4 py-3 mt-3">

        <div class="ms-3 mb-4 text-center p-2" style="background-color:rgba(247, 247, 247, 0.651)">
            <h1 class="display-4 fw-bold" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);">
                <img src="{{ asset('assets/images/logos/logo2.png') }}" alt="Logo" style="max-height: 10vh" class="img-fluid">
                <ins>
                    Administración General
                </ins>
            </h1>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card adminCard">
                    <div class="card-header admin-card-header text-center">
                        <h2>
                            {{ __('Administración General') }}
                        </h2>
                    </div>

                    <div class="card-body admin-card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="row justify-content-center">
                            @if (Auth::user()->isAdmin())
                                <div class="col-md-4 mb-4 d-flex align-items-center justify-content-center">
                                    <div class="card admin-list-card">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">{{ __('Gestión de Usuarios') }}</h5>
                                            <a href="{{ route('user.list') }}"
                                                class="btn btn-primary">{{ __('Ir a la gestión') }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="col-md-4 mb-4 d-flex align-items-center justify-content-center">
                                <div class="card admin-list-card">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">{{ __('Gestión de Libros, autores y géneros') }}</h5>
                                        <a href="{{ route('books.management') }}"
                                            class="btn btn-primary">{{ __('Ir a la gestión') }}</a>
                                    </div>
                                </div>
                            </div>

                            @if (Auth::user()->isAdmin())
                                <div class="col-md-4 mb-4 d-flex align-items-center justify-content-center">
                                    <div class="card admin-list-card">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">{{ __('Gestión de Subadministradores') }}</h5>
                                            <a href="{{ route('subadmins.list') }}"
                                                class="btn btn-primary">{{ __('Ir a la gestión') }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
