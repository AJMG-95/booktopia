<!-- Partial: books_carousel.blade.php -->
<div id="booksCarousel" class="carousel slide mt-4 text-center " data-bs-ride="carousel">
    <h2 class="mb-3">Libros Sugeridos</h2>
    <div class="carousel-inner border border-1 border-black rounded p-4 " style="min-height: 500;max-height: 500px;">
        @foreach ($randomBooks as $index => $book)
            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                <div class="card mx-auto" style="max-width: 20vw">
                    <div class="card-header">
                        {{ $book->title }}
                    </div>
                    <div class="card-body">
                        <img src="{{ asset('storage/' . $book->cover) }}" alt="Imagen del Género" class="rounded"
                            style="max-height: 25vh">
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('books.details', $book->id) }}" class="btn btn-primary">Ver Detalle</a>
                        @auth
                            @php
                                $user = Auth::user();
                                $isInWishlist = $user->wishes->contains('book_id', $book->id);
                            @endphp

                            @if (!$isInWishlist)
                                <form action="{{ route('wishes.add', ['id' => $book->id]) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-primary"><i class="bi bi-bookmark"></i></button>
                                </form>
                            @else
                                <form action="{{ route('wishes.remove', ['id' => $book->id]) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"><i class="bi bi-bookmark-fill"></i></button>
                                </form>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#booksCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#booksCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Siguiente</span>
    </button>
</div>
