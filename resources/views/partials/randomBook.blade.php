<div class=" d-flex justify-content-center mx-auto px-auto" >
    <div class="container-fluid mt-4 ms-4">
        <div>
            <h2>Libros recomendados</h2>
        </div>
        <div class="row ms-5 cardsContainer" style="">
            @foreach ($randomBooks as $book)
                <div class="bookCard card col-md-2">
                    <div class="image-container">
                        <img src="{{ 'assets/images/bookCovers' . '/' . $book->cover }}" alt="Portada del libro">
                    </div>
                    <div class="content">
                        <ul class="cardDefinition">
                            <li><h5>Título</h5></li>
                            <li><p>{{ $book->original_title }}</p></li>
                            <li><h5>Autores</h5></li>
                            <li>
                                <ul>
                                    @foreach ($book->authors as $author)
                                        <li><p>{{ $author->name }}</p></li>
                                    @endforeach
                                </ul>
                            </li>
                            <li><h5>Géneros</h5></li>
                            <li>
                                <ul>
                                    @foreach ($book->genres as $genre)
                                        <li><p>{{ $genre->genre }}</p></li>
                                    @endforeach
                                </ul>
                            </li>
                        <ul/>
                    </div>
                    <div class="verDetalle">
                        <a class="" href="">
                            Ver
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>
