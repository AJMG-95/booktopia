<!-- resources/views/components/book/forGenre.blade.php -->
@extends('layouts.app') {{-- Adjust according to the structure of your layout --}}

@section('content')
    <div class="container-fluid mt-4 ms-4 p-4">
        <div class="mt-4 ms-4">
            <h1>Libros del género "{{ $genre->genre }}"</h1>
        </div>
        <div class="row">
            @forelse ($books as $book)
                <div class="col-md-4">
                    <div class="card">
                        <img src="{{ asset('assets/images/bookCovers/' . $book->cover) }}" class="card-img-top"
                            alt="Portada del libro">
                        <div class="card-body">
                            <h5 class="card-title">{{ $book->original_title }}</h5>
                            <p class="card-text">{{ $book->description }}</p>
                            <p class="card-text">Autores:
                                @forelse ($book->authors->take(2) as $author)
                                    {{ $author->name }}@if (!$loop->last)
                                        ,
                                    @endif
                                @empty
                                    <em>No hay autores asignados.</em>
                                @endforelse
                            </p>
                            <p class="card-text">Géneros:
                                @forelse ($book->genres->take(2) as $bookGenre)
                                    {{ $bookGenre->genre }}@if (!$loop->last)
                                        ,
                                    @endif
                                @empty
                                    <em>No hay géneros asignados.</em>
                                @endforelse
                            </p>
                            <a href="{{ route('books.show', ['id' => $book->id]) }}" class="btn btn-primary">Ver
                                Detalles</a>
                        </div>
                    </div>
                </div>
            @empty
                <p>No hay libros disponibles para este género.</p>
            @endforelse
        </div>
    </div>
@endsection
