<div class="container-fluid mt-4">
    <div class="mt-4 ms-4">
        <h2>Géneros recomendados</h2>
    </div>

    <div class=" cardsContainer" style="">
        @foreach ($randomGenres as $genre)
            <div class="bookCard card ">
                <div class="image-container">
                    <img src="{{ asset('assets/images/genres/' . $genre->img_url) }}" alt="{{ $genre->genre }}">

                </div>
                <div class="content">
                    <ul class="cardDefinition">
                        <li>
                            <h5>Nombre</h5>
                        </li>
                        <li>
                            <p>{{ $genre->genre }}</p>
                        </li>
                        <li>
                            <h5>Descrición</h5>
                        </li>
                        <li>
                            <p>{{ $genre->description }}</p>
                        </li>

                    </ul>
                </div>
                <div class="verDetalle">
                    <a class="" href="{{ route('genre.show', ['id' => $genre->id]) }}">
                        Ver
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
