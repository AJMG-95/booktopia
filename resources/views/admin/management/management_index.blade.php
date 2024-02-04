@extends('layouts.app')

@section('content')
    <div class="container-fluid ms-0 me-0 px-4 py-3 mt-3">

        <div class="ms-3 mb-4 text-center p-2" style="background-color:rgba(247, 247, 247, 0.651)">
            <h1 class="display-4 fw-bold" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);">
                <img src="{{ asset('assets/images/logos/logo2.png') }}" alt="Logo" style="max-height: 10vh" class="img-fluid">
                <ins>
                    Gestión General de Libros
                </ins>
            </h1>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card adminCard">
                    <div class="card-header admin-card-header text-center">
                        <h2>
                            {{ __('Gestión de libros') }}
                        </h2>
                    </div>

                    <div class="card-body admin-card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-4 d-flex align-items-center justify-content-center">
                                <div class="card admin-list-card">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">{{ __('Gestión de Autores') }}</h5>
                                        <a href="{{ route('authors.list') }}"
                                            class="btn btn-primary">{{ __('Ir a la gestión') }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 d-flex align-items-center justify-content-center">
                                <div class="card admin-list-card">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">{{ __('Gestión de Géneros') }}</h5>
                                        <a href="{{ route('genres.list') }}"
                                            class="btn btn-primary">{{ __('Ir a la gestión') }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4  d-flex align-items-center justify-content-center">
                                <div class="card admin-list-card">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">{{ __('Gestión de Libros') }}</h5>
                                        <a href="{{ route('books.list') }}"
                                            class="btn btn-primary">{{ __('Ir a la gestión') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="btn books-editions-btn mb-2">
                        <a href="{{ route('home') }}"
                            class="btn btn-primary">{{ __('Volver a Administración General') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
