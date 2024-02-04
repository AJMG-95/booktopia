@extends('layouts.app')

@section('content')
    <div class="container-fluid ms-0 me-0 px-4 py-3 mt-3">

        <div class="ms-3 mb-4 text-center p-2" style="background-color:rgba(247, 247, 247, 0.651)">
            <h1 class="display-4 fw-bold" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);">
                <img src="{{ asset('assets/images/logos/logo2.png') }}" alt="Logo" style="max-height: 10vh" class="img-fluid">
                <ins>
                    Bienvenido a tu librería
                </ins>
            </h1>
        </div>

        <aside class="bg-white ms-4 rounded-2" style="max-width: 600px">
            <form action="{{ route('user.library.search') }}" method="GET" class="p-2">
                <div class="d-flex justify-content-around align-items-center flex-wrap">
                    <label for="sortBy" class="mb-2 mb-md-0 me-md-2">Ordenar por:</label>
                    <select name="sortBy" class="form-select w-auto mb-2 mb-md-0 border-1 border-black rounded">
                        <option value="asc_title" @if (request('sortBy') == 'asc_title') selected @endif>A-Z</option>
                        <option value="desc_title" @if (request('sortBy') == 'desc_title') selected @endif>Z-A</option>
                    </select>
                    <select name="orderDirection"
                        class="form-select ms-0 ms-md-2 w-auto mb-2 mb-md-0 border-1 border-black rounded px-1">
                        <option value="desc" @if (request('orderDirection', 'desc') == 'desc') selected @endif>Más reciente a más antiguo
                        </option>
                        <option value="asc" @if (request('orderDirection') == 'asc') selected @endif>Más antiguo a más reciente
                        </option>
                    </select>
                    <button type="submit" class="btn btn-primary ms-0 ms-md-2">Ordenar</button>
                </div>
            </form>
        </aside>



        {{-- Área principal para mostrar los libros --}}
        <main class="ms-4 pt-4">
            <div class="row row-cols-1 row-cols-md-3 pe-4">
                @if ($books->isEmpty())
                    <div class="alert alert-info">
                        No se encontraron libros con los filtros aplicados.
                    </div>
                @else
                    @foreach ($books as $book)
                        <div class="col-12 col-md-4 mb-4">
                            <div class="card">
                                <div class="card-header text-center text-light">
                                    <h5>{{ $book->title }}</h5>
                                </div>
                                <div class="card-body text-center">
                                    <img src="{{ asset('storage/' . $book->cover) }}"
                                        class="card-img-top rounded-1 img-fluid" alt="{{ $book->title }}"
                                        style="object-fit: cover; max-height: 200px; width: 100%;">
                                </div>
                                <div class="card-footer text-center">
                                    <div class="mb-3">
                                        <form method="post"
                                            action="{{ route('user.library.rate-book', ['id' => $book->book_id]) }}">
                                            @csrf
                                            <div class="row justify-content-around text-center mt-2 ratingForm">
                                                <div class="col-12 col-md-6 col-lg-4 rating"
                                                    data-book-id="{{ $book->book_id }}"></div>
                                                <input type="hidden" name="rating" class="ratingInput col-12 col-md-auto"
                                                    value="{{ $userRatings->get($book->book_id) }}">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="row">
                                        <div class="col-4 mb-3 mb-md-0 text-center">
                                            <a href="{{ route('user.library.book.details', $book->book_id) }}"
                                                class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Ver Detalles">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </div>
                                        <div class="col-4 mb-3 mb-md-0 text-center">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#commentModal{{ $book->book_id }}" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Comentar">
                                                <i class="bi bi-chat-square-text"></i>
                                            </button>
                                            <!-- Modal para Comentarios -->
                                            <div class="modal fade" id="commentModal{{ $book->book_id }}" tabindex="-1"
                                                aria-labelledby="commentModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="commentModalLabel">Comentar
                                                                sobre
                                                                {{ $book->title }}</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- Formulario para comentarios -->
                                                            <form method="post"
                                                                action="{{ route('user.library.add-comment', ['id' => $book->book_id]) }}">
                                                                @csrf
                                                                <div class="mb-3">
                                                                    <label for="comment">Tu comentario:</label>
                                                                    <textarea class="form-control" name="comment" rows="3" required></textarea>
                                                                </div>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Comentar</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4 text-center">
                                            <a href="{{ route('user.library.read', $book->book_id) }}" target="_blank"
                                                class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Leer Libro">
                                                <i class="bi bi-book"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </main>


    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>

    <script>
        $(document).ready(function() {
            $('form').submit(function() {
                $('#searchBtn .spinner-border').removeClass('d-none');
            });


            $('.rating').each(function() {
                var currentRating = $(this).siblings('.ratingInput').val() || 0;

                $(this).rateYo({
                    rating: currentRating,
                    fullStar: true,
                    onSet: function(rating, rateYoInstance) {
                        $(this).siblings('.ratingInput').val(rating);
                        $(this).closest('.ratingForm').submit();
                    }
                });
            });
        });
    </script>

@endsection
