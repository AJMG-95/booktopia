<div class="container">
    <h2>Libros recomendados</h2>

    <div >

    </div>
    @foreach ($randomBooks as $book)
        <div class="bookCard card">
            <div class="image-container">
                <img src="{{ 'assets/images/bookCovers' . '/' . $book->cover }}" alt="Portada del libro">
            </div>
            <div class="content">
                <dl>
                    <dt>Título</dt>
                    <dd>{{ $book->original_title }}</dd>
                    <dt>Autores</dt>
                    <dd>
                        <ul>
                            @foreach ($book->authors as $author)
                                <li>{{ $author->name }}</li>
                            @endforeach
                        </ul>
                    </dd>
                    <dt>Géneros</dt>
                    <dd>
                        <ul>
                            @foreach ($book->genres as $genre)
                                <li>{{ $genre->genre }}</li>
                            @endforeach
                        </ul>
                    </dd>
                </dl>
            </div>
            <div class="social-links">
                <a class="instagram" href="https://instagram.com/parth.webdev">
                    Ver
                </a>
            </div>
        </div>
    @endforeach

</div>
