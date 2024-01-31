<!-- Partial: books_carousel.blade.php -->
<div id="booksCarousel" class="carousel slide mt-4 text-center container-fluid ms-0 me-0 px-3 py-3 mt-2" style="height: 70vh">
    <h2 class="display-4 fw-bold" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);"> Libros Sugeridos</h2>
    <div class="carousel-inner rounded p-4 mx-auto" style="max-width: 50vw; max-height: 500px;">
        @foreach ($randomBooks as $index => $book)
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
                                <h3>{{ $book->title }}</h3>
                                <p>{{ $book->short_description }}</p>
                            </div>
                            <div class="my-3 border border-black rounded p-2"
                                style=" background-color:rgba(247, 247, 247, 0.795)">
                                <p class="mt-2">
                                    Precio: <strong>{{ number_format($book->price, 2) }} €</strong>
                                </p>
                                <p class="text-success">
                                    <a class="text-success" href="{{ route('subscribe.view') }}" style="text-decoration: underline"><strong><ins>Precio con suscripción</ins></a>:
                                    {{ number_format($book->price * 0.8, 2) }} €</>
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
        <button class="carousel-control-prev" type="button" data-bs-target="#booksCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#booksCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
    </div>
</div>
