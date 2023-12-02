<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Random Books</title>
    @vite(['resources/css/partials/randomBooks.css'])
</head>

<body>


    <div class="container-fluid mt-4">
        <div class="mt-4 ms-4">
            <h2>Libros recomendados</h2>
        </div>

        <div class=" cardsContainer" style="">
            @foreach ($randomBooks as $book)
                <div class="bookCard card ">
                    <div class="image-container">
                        <img src="{{ 'assets/images/bookCovers/' . $book->cover }}" alt="{{ $book->original_title }}">

                    </div>
                    <div class="content">
                        <ul class="cardDefinition">
                            <li>
                                <h5>Título</h5>
                            </li>
                            <li>
                                <p>{{ $book->original_title }}</p>
                            </li>
                            <li>
                                <h5>Autores</h5>
                            </li>
                            <li>
                                <ul>
                                    @foreach ($book->authors->take(1) as $author)
                                        <li>
                                            <p>
                                                {{ $author->name }}
                                                @if ($book->authors->count() > 1)
                                                    <span>...</span>
                                                @endif
                                            </p>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                            <li>
                                <h5>Géneros</h5>
                            </li>
                            <li>
                                <ul>
                                    @foreach ($book->genres->take(1) as $genre)
                                        <li>
                                            <p>
                                                {{ $genre->genre }}
                                                @if ($book->genres->count() > 1)
                                                    <span>...</span>
                                                @endif
                                            </p>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="verDetalle">
                        <a class="" href="{{ route('books.show', ['id' => $book->id]) }}">
                            Ver
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</body>

</html>
