<!-- Partial: books_carousel.blade.php -->
<style>
    /* Estilo para cambiar el color de los iconos a negro y hacerlos círculos */
    .carousel-control-prev,
    .carousel-control-next {
        padding: 10px;
        /* Ajusta el espacio alrededor de los iconos */
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-color: black;
        border-radius: 50%;
        /* Hace que el fondo sea un círculo */
    }

    /* Estilo para cambiar el color de los iconos a blanco en modo hover */
    .carousel-control-prev:hover .carousel-control-prev-icon,
    .carousel-control-next:hover .carousel-control-next-icon {
        background-color: black;
        border-radius: 50%;
        /* Hace que el fondo sea un círculo en modo hover */
    }
</style>
<div id="leastSellingBooksCarousel" class="carousel slide mt-4 text-center container-fluid ms-0 me-0 px-3 py-3 mt-2"
    style="height: 70vh">
    <h2 class="display-4 fw-bold" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);"> Recomendaciones</h2>
    <div class="carousel-inner rounded p-4 mx-auto" style="width:30vw; min-width: 40vw; max-height: 500px;">
        @foreach ($leastSellingBooks as $index => $book)
            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                <div class="container p-3 border border-black rounded"
                    style="max-width: 40vw; background-color:rgba(247, 247, 247, 0.651)">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <img src="{{ asset('storage/' . $book->cover) }}" alt="Imagen del Género"
                                class="img-fluid rounded" style="max-height: 25vh;">
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h3 class="text-break text-nowrap">{{ $book->title }}</h3>
                                <div>
                                    @forelse ($book->authors as $author)
                                        <p class="text-truncate text-muted ">
                                            {{ $author->nickname ? $author->nickname : $author->surnames . ', ' . $author->name }}
                                        </p>
                                    @empty
                                        <p class="text-muted">Anónimo</p>
                                    @endforelse
                                </div>
                            </div>
                            <div class="my-3 border border-black rounded p-2"
                                style=" background-color:rgba(247, 247, 247, 0.795)">
                                <p class="mt-2">
                                    Precio: <strong>{{ number_format($book->price, 2, ',', '.') }} €</strong>
                                </p>
                                <p class="text-success">
                                    <a class="text-success" href="{{ route('subscribe.view') }}"
                                        style="text-decoration: underline"><strong><ins>Precio con
                                                suscripción</ins></a>:
                                    {{ number_format($book->price * 0.8, 2, ',', '.') }} €</>
                                </p>
                            </div>
                            <div>
                                <a href="{{ route('books.details', $book->id) }}" class="btn btn-primary">Ver
                                    Detalle</a>
                                @auth
                                    @php
                                        $user = Auth::user();
                                        $isInWishlist = $user->wishes->contains('book_id', $book->id);
                                    @endphp

                                    @if (!$isInWishlist)
                                        <form action="{{ route('wishes.add', ['id' => $book->id]) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-primary"><i
                                                    class="bi bi-bookmark"></i></button>
                                        </form>
                                    @else
                                        <form action="{{ route('wishes.remove', ['id' => $book->id]) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"><i
                                                    class="bi bi-bookmark-fill"></i></button>
                                        </form>
                                    @endif
                                @endauth
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <button class="carousel-control-prev" type="button" data-bs-target="#leastSellingBooksCarousel"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#leastSellingBooksCarousel"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
    </div>
</div>
