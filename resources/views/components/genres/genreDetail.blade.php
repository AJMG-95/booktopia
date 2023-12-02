{{-- resources/views/components/genres/genreDetail.blade.php --}}

@extends('layouts.app') {{-- Adjust according to the structure of your layout --}}

@section('content')
    <div class="container-fluid mt-4 ms-4 p-4 genre-detail">
        <div class="genre-detail mt-4 ms-4">
            <h1>{{ $genre->genre }}</h1>
        </div>
        <div class="genre-detail row">
            <div class="genre-detail col-md-4 m-auto p-auto">
                <img src="{{ asset('assets/images/genres/' . $genre->img_url) }}" alt="{{ $genre->genre }}">
            </div>
            <div class="genre-detail col-md-8 row">
                <div class="genre-detail col-md-6">
                    <dl class="genre-detail mt-1">
                        <dt>
                            <h4>Descripción</h4>
                        </dt>
                        <dd class="genre-detail ms-4">
                            {{ $genre->description ?: 'Esta categoría no tiene descripción.' }}
                        </dd>

                        <dt>Número de libros</dt>
                        <dd class="genre-detail ms-4">{{ $genre->books->count() }}</dd>

                        <dt>
                            <h4>Ver libros de este género</h4>
                        </dt>
                        <dd class="genre-detail ms-4">
                            <a href="{{ route('books.forGenre', ['genre' => $genre->id]) }}">
                                Ver todos los libros de este género
                            </a>

                        </dd>
                    </dl>
                </div>
                <div class="genre-detail col-md-6 p-4 text-center">
                    <p class="genre-detail pe-4 text-center">
                        {{-- Additional details or description --}}
                        {{-- Customize this section based on your requirements --}}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
