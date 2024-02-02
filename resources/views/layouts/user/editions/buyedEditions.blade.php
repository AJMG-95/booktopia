@extends('layouts.app')

@section('content')
    <div class="container-fluid ms-0 me-0 px-4 py-3 mt-3">

        <div class="ms-3 mb-4 text-center p-2" style="background-color:rgba(247, 247, 247, 0.651)">
            <h1 class="display-4 fw-bold" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);">
                <img src="{{ asset('assets/images/logos/logo2.png') }}" alt="Logo" style="max-height: 10vh">
                <ins>
                    Bienvenido a tu librería
                </ins>
            </h1>
        </div>

        <aside class="bg-white ms-4 rounded-2" style="max-width: 600px">
            <form action="{{ route('user.library.search') }}" method="GET" class="w-auto p-2">
                <div class="d-flex justify-content-around align-items-center">
                    <label for="sortBy">Ordenar por: </label> &nbsp;&nbsp;&nbsp;
                    <select name="sortBy" class="form-select w-auto border-1 border-black rounded">
                        <option value="asc_title" @if (request('sortBy') == 'asc_title') selected @endif>A-Z</option>
                        <option value="desc_title" @if (request('sortBy') == 'desc_title') selected @endif>Z-A</option>
                    </select>
                    <select name="orderDirection" class="form-select ms-2 w-auto border-1 border-black rounded ">
                        <option value="desc" @if (request('orderDirection', 'desc') == 'desc') selected @endif>Más reciente a más
                            antiguo</option>
                        <option value="asc" @if (request('orderDirection') == 'asc') selected @endif>Más antiguo a más
                            reciente</option>
                    </select>
                    <button type="submit" class="btn btn-primary ms-2">Ordenar</button>
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
                        <div class="card ms-3 border border-black rounded p-1 mx-4"
                            style="max-width: 15vw; background-color:rgba(247, 247, 247, 0.651)">
                            <div class="card-header text-center">
                                <h5>{{ $book->title }}</h5>
                            </div>
                            <div class="card-body text-center">
                                <div style="max-width: 150px; max-height: 150px; margin: auto" class="mt-1 border rounded-1 mb-2 overflow-hidden">
                                    <img src="{{ asset('storage/' . $book->cover)  }}" class="card-img-top rounded-1 img-fluid"
                                        alt="{{ $book->title }}" style="object-fit: cover;">
                                </div>
                            </div>
                            <div class="card-footer  text-center">
                                <div class="mb-3">
                                    <form method="post"
                                        action="{{ route('user.library.rate-book', ['id' => $book->book_id]) }}"
                                        class="row justify-content-around text-center mt-2 ratingForm">
                                        @csrf
                                        <div class="rating" data-book-id="{{ $book->book_id }}"></div>
                                        <input type="hidden" name="rating" class="ratingInput"
                                            value="{{ $userRatings->get($book->book_id) }}">
                                    </form>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <a href="{{ route('user.library.book.details', $book->book_id) }}"
                                            class="btn btn-primary">
                                            <i class="bi bi-eye "></i>
                                        </a>
                                    </div>
                                    <div class="col-4">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#commentModal{{ $book->book_id }}">
                                            <i class="bi bi-chat-square-text"></i>
                                        </button>

                                        <!-- Modal para Comentarios -->
                                        <div class="modal fade" id="commentModal{{ $book->book_id }}" tabindex="-1"
                                            aria-labelledby="commentModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="commentModalLabel">Comentar sobre
                                                            {{ $book->title }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
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
                                                            <button type="submit" class="btn btn-primary">Comentar</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-4">

                                        <a href="{{ route('user.library.read', $book->book_id) }}" target="_blank"
                                            class="btn btn-primary">
                                            <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="1vw"
                                                height="1vw" viewBox="0 0 512.000000 512.000000"
                                                preserveAspectRatio="xMidYMid meet">

                                                <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                                    fill="#000000" stroke="none">
                                                    <path d="M1357 5100 l-27 -21 0 -185 c0 -101 -4 -184 -8 -184 -4 0 -59 17
                                                                        -122 39 -63 21 -159 49 -212 62 l-98 23 -27 -21 -28 -20 -3 -534 -2 -535 -129
                                                                        -36 c-71 -20 -176 -55 -235 -78 -104 -41 -136 -65 -136 -102 0 -16 -10 -18
                                                                        -77 -18 -133 0 -200 -30 -234 -104 -18 -39 -19 -92 -19 -1217 0 -1106 1 -1178
                                                                        18 -1197 27 -32 81 -33 112 -2 20 20 20 33 20 1184 0 988 2 1165 14 1175 9 7
                                                                        42 11 88 9 l73 -3 3 -1492 2 -1492 26 -20 27 -21 2177 0 2177 0 27 21 26 20 2
                                                                        1492 3 1492 76 3 c56 2 79 -1 87 -11 9 -11 11 -408 10 -1593 l-3 -1579 -1089
                                                                        -3 c-1061 -2 -1090 -2 -1110 17 -48 44 -109 66 -193 69 -72 4 -89 1 -140 -23
                                                                        -32 -14 -67 -35 -79 -46 -20 -19 -42 -19 -1110 -17 l-1089 3 -5 223 c-5 207
                                                                        -6 225 -24 238 -29 21 -82 18 -106 -6 -19 -19 -20 -33 -20 -245 0 -202 2 -230
                                                                        19 -263 23 -46 46 -67 94 -87 32 -13 171 -15 1156 -15 l1120 0 33 28 c63 54
                                                                        81 62 138 62 57 0 75 -8 138 -62 l33 -28 1120 0 c985 0 1124 2 1156 15 48 20
                                                                        71 41 94 87 18 36 19 87 19 1640 0 1542 -1 1605 -19 1644 -33 74 -101 104
                                                                        -232 104 l-76 0 -6 30 c-8 38 -36 56 -176 106 l-116 42 -3 261 -2 260 -27 20
                                                                        c-20 17 -40 21 -92 21 -87 0 -281 -17 -404 -35 -447 -66 -921 -260 -1259 -516
                                                                        -86 -65 -82 -67 -93 36 -9 88 -51 270 -87 377 -164 497 -480 827 -937 978
                                                                        -158 52 -199 58 -234 30z m313 -219 c160 -69 324 -190 434 -321 189 -224 300
                                                                        -486 362 -855 16 -89 18 -229 21 -1310 2 -665 2 -1207 -1 -1204 -3 2 -31 57
                                                                        -64 120 -79 156 -157 265 -277 385 -156 158 -347 273 -569 345 l-96 31 0 1439
                                                                        0 1438 52 -16 c29 -8 91 -32 138 -52z m-548 -265 c73 -24 150 -51 171 -60 l37
                                                                        -16 0 -1278 c0 -1123 2 -1280 15 -1299 10 -14 34 -26 71 -33 30 -6 94 -25 142
                                                                        -41 389 -131 667 -419 817 -849 36 -104 80 -269 73 -276 -2 -2 -33 36 -70 84
                                                                        -326 433 -782 753 -1278 897 l-115 33 -3 1441 c-1 793 0 1441 3 1441 3 0 65
                                                                        -20 137 -44z m3220 -935 c3 -376 4 -400 22 -420 25 -27 79 -28 106 -1 18 18
                                                                        20 33 20 136 0 107 1 116 18 109 9 -4 43 -16 75 -27 l57 -20 0 -1365 0 -1365
                                                                        -22 5 c-13 2 -66 16 -118 31 -133 37 -332 73 -484 87 -156 14 -462 7 -591 -15
                                                                        -49 -8 -91 -14 -93 -12 -6 6 146 62 269 100 228 69 438 104 691 115 133 5 159
                                                                        9 177 25 21 19 21 20 21 916 0 842 -1 899 -18 919 -24 30 -76 31 -105 2 l-22
                                                                        -22 -3 -843 -2 -843 -115 -7 c-538 -30 -1086 -224 -1495 -526 -44 -33 -82 -60
                                                                        -85 -60 -3 0 -5 636 -5 1414 l0 1414 53 47 c124 109 332 243 522 335 320 155
                                                                        727 255 1087 269 l37 1 3 -399z m-3512 -1059 c0 -882 1 -940 18 -955 9 -8 62
                                                                        -27 118 -41 406 -103 765 -309 1072 -616 91 -91 239 -267 284 -338 l19 -30
                                                                        -106 44 c-182 75 -325 115 -540 151 -87 14 -163 18 -360 17 -285 0 -424 -17
                                                                        -670 -80 -77 -19 -150 -38 -162 -41 l-23 -5 0 1365 0 1365 68 23 c131 45 237
                                                                        77 260 78 l22 1 0 -938z m741 -1922 c238 -24 487 -93 677 -186 l107 -52 -937
                                                                        -1 -938 -1 0 54 0 53 108 32 c173 50 321 79 547 105 71 8 341 5 436 -4z m2573
                                                                        -15 c137 -22 262 -49 389 -86 l107 -32 0 -53 0 -54 -937 1 -938 1 107 52 c182
                                                                        89 433 160 658 185 122 14 495 5 614 -14z" />
                                                </g>
                                            </svg>
                                        </a>
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
