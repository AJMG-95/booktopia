<div id="carouselGenres" class="carousel slide mt-4 text-center " data-bs-ride="carousel">
    <h2 class="mb-3">Géneros Sugeridos</h2>
    <div class="carousel-inner border border-1 border-black rounded p-4" style="min-height: 500; max-height: 500px; ">
        @foreach ($randomGenres as $index => $genre)
            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                <div class="card mx-auto" style="max-width: 20vw;  min-height: 42vh;  max-height: 42vh">
                    <div class="card-header">
                        {{ $genre->genre_name }}
                    </div>
                    <div class="card-body">
                        <img src="{{ asset('storage/' . $genre->img_url) }}" alt="Imagen del Género" class="rounded" style="max-width: 15vw">
                    </div>
                    <div class="card-footer">
                        <a href="{{-- {{ route('genres.show', $genre->id) }} --}}" class="btn btn-primary">Ver Detalle</a>
                    </div>
                </div>
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
