@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Libros recomendados</h2>

        @foreach ($randomBooks as $book)
            <div>
                <div>
                    <img src="{{ $book->cover }}" alt="Portada del libro">
                    <h3>Título</h3>
                    <p>{{ $book->original_title }}</p>
                    <h4>Autores</h4>
                    <ul>
                        @foreach ($book->authors as $author)
                            <li>{{ $author->name }}</li>
                        @endforeach
                    </ul>
                    <h4>Géneros</h4>
                    <ul>
                        @foreach ($book->genres as $genre)
                            <li>{{ $genre->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach
    </div>
@endsection
