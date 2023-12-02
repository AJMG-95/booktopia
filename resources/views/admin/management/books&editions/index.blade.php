<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Books Editions Autors & Genres Adminstration Index</title>
    @vite(['resources/css/booksEditionsIndex.css'])
</head>

<body>

</body>

</html>
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card bookEditionCard">
                    <div class="card-header bookEditionCard-header">{{ __('Gestión de libros y ediciones:') }}</div>

                    <div class="card-body bookEditionCard-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <ul class="list-group">
                            <li class="list-group-item">
                                <a href=" {{ route('authors.list') }}">{{ __('Gestión de Autores') }}</a>
                            </li>
                            <li class="list-group-item">
                                <a href="{{ route('genres.list') }}">{{ __('Gestión de Generos') }}</a>
                            </li>
                            <li class="list-group-item">
                                <a href="{{ route('books.list') }}">{{ __('Gestión de Libros') }}</a>
                            </li>
                            <li class="list-group-item">
                                <a href="{{ route('editions.list') }}">{{ __('Gestión de Ediciones') }}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="btn books-editions-btn ">
                        <a href="{{ route('home') }}" class="">{{ __('Administración General') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
