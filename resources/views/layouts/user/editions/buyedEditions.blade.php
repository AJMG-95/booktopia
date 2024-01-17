@extends('layouts.app')

@section('content')
    <div class="container-fluid p-4">

        <div class="row">
            {{-- Menú lateral de filtros --}}
            <aside class="col-lg-3 col-md-4 pt-4">
                <h2>Buscar...</h2>
                <form action="{{ route('user.library.search') }}" method="GET" class="p-3">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" name="title" class="form-control" placeholder="Buscar por Título"
                            value="{{ old('title', request('title')) }}" />
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" name="author" class="form-control" placeholder="Buscar por Autor"
                            value="{{ old('author', request('author')) }}" />
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="bi bi-bookmark"></i></span>
                        <input type="text" name="genre" class="form-control" placeholder="Buscar por Género"
                            value="{{ old('genre', request('genre')) }}" />
                    </div>
                    <div class="mb-3">
                        <label for="language" class="form-label">Idioma</label>
                        <select name="language" class="form-select">
                            <option value="" selected>Todos los idiomas</option>
                            @foreach ($languages as $language)
                                <option value="{{ $language->id }}" @if (old('language', request('language')) == $language->id) selected @endif>
                                    {{ $language->language }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="autopublicado" value="1" class="form-check-input"
                            @if (old('autopublicado', request('autopublicado'))) checked @endif>
                        <label for="autopublicado">Solo libros autopublicados</label>
                    </div>
                    @if (Auth::user()->isAdult())
                        <div class="mb-3 form-check">
                            <input type="checkbox" name="for_adults" value="1" class="form-check-input"
                                @if (old('for_adults', request('for_adults'))) checked @endif>
                            <label for="for_adults" class="form-check-label">Solo libros para adultos</label>
                        </div>
                    @else
                        <input type="hidden" name="for_adults" value="0">
                    @endif
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-block" id="searchBtn">
                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            Aplicar Filtros
                        </button>
                        <a href="{{ route('user.library') }}" class="btn btn-primary btn-block mt-2">
                            Borrar Filtros
                        </a>
                    </div>
                </form>

            </aside>

            {{-- Área principal para mostrar los libros --}}
            <main class="col-lg-9 col-md-8 col-ms-7 pt-4">
                {{-- Ordenar por: --}}
                <form action="{{ route('user.library.search') }}" method="GET">
                    <!-- ... otros campos ... -->
                    <div class="d-flex justify-content-left align-items-center mb-4">
                        <select name="sortBy" class="form-select w-auto">
                            <option value="asc_title" @if (request('sortBy') == 'asc_title') selected @endif>A-Z</option>
                            <option value="desc_title" @if (request('sortBy') == 'desc_title') selected @endif>Z-A</option>
                        </select>
                        <select name="orderDirection" class="form-select ms-2 w-auto">
                            <option value="desc" @if (request('orderDirection', 'desc') == 'desc') selected @endif>Más reciente a más
                                antiguo</option>
                            <option value="asc" @if (request('orderDirection') == 'asc') selected @endif>Más antiguo a más
                                reciente</option>
                        </select>
                        <button type="submit" class="btn btn-primary ms-2">Ordenar</button>
                    </div>
                </form>
                {{-- Área para mostrar los libros --}}
                <div class="row row-cols-1 row-cols-md-3 pe-4">
                    @if ($books->isEmpty())
                        <div class="alert alert-info">
                            No se encontraron libros con los filtros aplicados.
                        </div>
                    @else
                        @foreach ($books as $book)
                            <div class="card ms-3" style="max-width: 15vw; background-color:bisque">
                                <div style="width: 150px; height:150px; margin: auto" class="mt-1 border rounded-1 ">
                                    <img src="{{ $book->cover ? asset('storage/' . $book->cover) : 'No Image' }}"
                                        class="card-img-top rounded-1" alt="{{ $book->title }}"
                                        style="object-fit: cover; width:100%; height: 100%">
                                </div>
                                <div class="card-body">
                                    <h5>{{ $book->title }}</h5>
                                    <p class="card-text">
                                        <strong>Autor:</strong>
                                        @if ($book->authors->isNotEmpty())
                                            {{ $book->authors->first()->name }}
                                        @else
                                            Sin autor
                                        @endif
                                    </p>
                                    <p class="card-text">
                                        <strong>Género:</strong>

                                        @if ($book->genres->isNotEmpty())
                                            @if ($book->genres->count() >= 2)
                                                @foreach ($book->genres->take(2) as $genre)
                                                    {{ $genre->genre_name }}
                                                    @if (!$loop->last)
                                                        {{ ',' }}
                                                    @else
                                                        {{ ', ...' }}
                                                    @endif
                                                @endforeach
                                            @else
                                                {{ $book->genres->first()->genre_name }}
                                            @endif
                                        @else
                                            Sin género
                                        @endif
                                        {{ $book->price }}
                                </div>
                                <div class="card-footer row text-center">
                                    <div class="col-auto">
                                        <a href="{{ route('user.library.book.details', $book->book_id) }}"
                                            class="btn btn-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </div>

                                    <div class="col-5">
                                        Meter aqui valoracion
                                    </div>

                                    <div class="col-auto">

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
                        @endforeach
                    @endif
                </div>
            </main>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('form').submit(function() {
                $('#searchBtn .spinner-border').removeClass('d-none');
            });
        });
    </script>
@endsection
