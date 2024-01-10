<div class="container ">
    <h2 >Géneros Recomendos</h2>

    <!-- Carrusel de Libros Aleatorios -->
    <div id="carouselGenres" class="carousel slide " data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach ($randomGenres as $index => $genre)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    @include('partials.genre_card', ['genre' => $genre])
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselGenres" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselGenres" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
    </div>
</div>
