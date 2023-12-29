@extends('layouts.app')

@section('content')
    <div class="container-fluid mb-4">
        <div class="row">
            {{-- Menú lateral de filtros --}}
            <aside class="col-lg-3 col-md-4 pt-4">
                <h2>Buscar...</h2>
                <form action="{{ route('user.buyed.editions') }}" method="GET" class="p-3">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" name="title" class="form-control" placeholder="Buscar por Título"
                            value="{{ old('title', $request->get('title')) }}" />
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" name="author" class="form-control" placeholder="Buscar por Autor"
                            value="{{ old('author', $request->get('author')) }}" />
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="bi bi-list"></i></span>
                        <input list="genres" name="genre" class="form-control" placeholder="Buscar por Género"
                            value="{{ old('genre', $request->get('genre')) }}" />
                        <datalist id="genres">
                            @foreach ($genres as $genre)
                                <option value="{{ $genre->genre }}">
                            @endforeach
                        </datalist>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">(max.) €</span>
                        <input type="number" name="max_price" class="form-control"
                            value="{{ old('max_price', $request->get('max_price')) }}" />
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">(min.) €</span>
                        <input type="number" name="min_price" class="form-control"
                            value="{{ old('min_price', $request->get('min_price')) }}" />
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="bi bi-upc-scan"></i></span>
                        <input type="text" name="isbn" class="form-control" placeholder="ISBN"
                            value="{{ old('isbn', $request->get('isbn')) }}" />
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="bi bi-globe"></i></span>
                        <input list="languages" name="language" class="form-control" placeholder="Seleccionar Idioma"
                            value="{{ old('language', $request->get('language')) }}">
                        <datalist id="languages">
                            @foreach ($languages as $language)
                                <option value="{{ $language->iso_code }}">{{ $language->language }}</option>
                            @endforeach
                        </datalist>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="autopublicado" value="0" class="form-check-input"
                            {{ old('autopublicado', $request->get('autopublicado')) == '0' ? 'checked' : '' }}>
                        <label for="autopublicado">Mostrar solo libros autopublicados</label>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-block">Aplicar Filtros</button>
                    </div>
                    <div class="d-grid gap-2 mt-3">
                        <a href="{{ route('user.buyed.editions') }}" class="btn btn-secondary btn-block">Borrar Filtros</a>
                    </div>
                </form>
            </aside>

            {{-- Área principal para mostrar los libros --}}
            <main class="col-lg-9 col-md-8 pt-4">
                <form action="{{ route('user.buyed.editions') }}" method="GET" class="me-2">
                    <div class="d-flex justify-content-left align-items-center mb-4">
                        <select name="sortBy" class="form-select w-auto">
                            <option value="asc_price" @if (request('sortBy') == 'asc_price') selected @endif>Menor a mayor €
                            </option>
                            <option value="desc_price" @if (request('sortBy') == 'desc_price') selected @endif>Mayor a menor €
                            </option>
                            <option value="asc_title" @if (request('sortBy') == 'asc_title') selected @endif>A-Z</option>
                            <option value="desc_title" @if (request('sortBy') == 'desc_title') selected @endif>Z-A</option>
                            <option value="publication_date" @if (request('sortBy') == 'publication_date') selected @endif>Más reciente
                            </option>
                        </select>
                        <button type="submit" class="btn btn-primary">Ordenar</button>
                    </div>
                </form>

                <div class="row row-cols-1 row-cols-md-3 g4">
                    @foreach ($purchasedEditions as $purchase)
                        <div class="col">
                            <div class="card h-100">
                                <img src="{{ $purchase->edition->cover ? asset('assets/images/editionCovers/' . $purchase->edition->cover) : 'No Image' }}"
                                    class="card-img-top" alt="{{ $purchase->edition->title }}">
                                <div class="card-body">
                                    <h5>{{ $purchase->edition->title }}</h5>
                                    <p class="card-text">{{ $purchase->edition->short_description }} </p>
                                </div>

                                <div class="card-footer row">
                                    <div class="col-6">
                                        <form action="{{ route('edition.show', ['id' => $purchase->edition->id]) }}"
                                            method="GET" class="col">
                                            @csrf
                                            <button type="submit" class="btn ">
                                                <svg version="1.1" id="Uploaded to svgrepo.com"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="2.5vw"
                                                    height="auto" viewBox="0 0 32.00 32.00" xml:space="preserve"
                                                    fill="#000000" transform="rotate(0)">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"
                                                        transform="translate(0,0), scale(1)">
                                                        <path transform="translate(0, 0), scale(1)"
                                                            d="M16,27.234812140464783C18.397045338808,27.10568122996473,20.63279318964606,29.967955500795668,22.856936050878858,29.06480009823479C25.014431574966792,28.18870811127453,24.910215850518682,24.979639685964642,26.2477570669976,23.07351597531637C27.598073710486766,21.149186063589678,30.678784216719723,20.142167200761683,30.76646115008493,17.792972998017778C30.856472480832515,15.381231525574641,28.099675682375235,13.89515851644649,26.662679773565337,11.956178958114645C25.5788153836647,10.493689828440182,24.531460296542974,9.096845942844817,23.316843313112507,7.740991211071199C21.963342481312655,6.230102978574808,20.983757284333596,4.201090470651818,19.082353679653,3.4943995305042925C17.156003652702978,2.7784368026292707,14.959744452787366,3.2322437248764477,13.021171882971831,3.9144192489136174C11.165258016966627,4.56750752315368,10.0162846683357,6.35574697543726,8.286605771501854,7.293377758756524C5.971226028686591,8.548507439711392,2.6170042807650615,8.18685200729833,1.129866670175188,10.360502300381878C-0.29301223168554347,12.440229905969904,0.04588471739579769,15.517446787369451,1.0913257306613993,17.810240796997768C2.1075425635473,20.03894221329882,5.329573188442481,20.390998276647423,6.6454689496033055,22.456966572682465C8.037602819374614,24.642629391633207,6.43626681757506,28.646373430184028,8.744041441897256,29.82507396587691C11.06486033335825,31.0104368872734,13.397763687720918,27.374996866594323,16,27.234812140464783"
                                                            fill="#7ad973" strokewidth="0"></path>
                                                    </g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                        stroke-linejoin="round"></g>
                                                    <g id="SVGRepo_iconCarrier">
                                                        <style type="text/css">
                                                            .feather_een {
                                                                fill: #000000;
                                                            }
                                                        </style>
                                                        <path class="feather_een"
                                                            d="M21.461,6.858L21.461,6.858c0,0-0.001,0-0.001,0C19.858,6.326,18.048,6,16,6 c-2.048,0-3.858,0.326-5.46,0.857c0,0,0,0,0,0l0,0C4.484,8.867,1.471,13.89,0.432,16.02c-0.3,0.616-0.276,1.334,0.081,1.918 C1.923,20.244,6.403,26,16,26s14.077-5.756,15.487-8.062c0.357-0.585,0.382-1.302,0.081-1.918 C30.529,13.89,27.516,8.867,21.461,6.858z M11.012,7.758C12.482,7.284,14.14,7,16,7c1.811,0,3.547,0.281,4.984,0.754 C22.903,9.285,24,11.552,24,14c0,4.411-3.589,8-8,8s-8-3.589-8-8C8,11.554,9.096,9.289,11.012,7.758z M16,25 c-9.181,0-13.359-5.452-14.64-7.58c-0.172-0.286-0.187-0.635-0.04-0.935c0.832-1.701,3.096-5.525,7.415-7.763 c-1.117,1.529-1.775,3.413-1.733,5.462c0.097,4.734,4.025,8.69,8.759,8.812C20.841,23.128,25,19.05,25,14 c0-1.998-0.665-3.832-1.769-5.324c4.386,2.227,6.636,6.086,7.459,7.808c0.143,0.298,0.127,0.642-0.044,0.926 C29.37,19.534,25.194,25,16,25z M11.159,12.809C11.064,13.192,11,13.587,11,14c0,2.761,2.239,5,5,5s5-2.239,5-5s-2.239-5-5-5 c-0.916,0-1.763,0.259-2.497,0.693C13.136,9.272,12.602,9,12,9c-1.105,0-2,0.895-2,2C10,11.803,10.476,12.491,11.159,12.809z M14,11 c0-0.144-0.017-0.284-0.046-0.419C14.555,10.22,15.25,10,16,10c2.206,0,4,1.794,4,4s-1.794,4-4,4s-4-1.794-4-4 c0-0.352,0.051-0.691,0.14-1.014C13.178,12.913,14,12.056,14,11z M12,10c0.552,0,1,0.448,1,1c0,0.552-0.448,1-1,1s-1-0.448-1-1 C11,10.448,11.448,10,12,10z">
                                                        </path>
                                                    </g>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{ route('pdf.show', ['editionId' => $purchase->edition->id]) }}"
                                            target="_blank" class="btn">
                                            <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="3vw"
                                                height="auto" viewBox="0 0 243.000000 218.000000"
                                                preserveAspectRatio="xMidYMid meet">

                                                <g transform="translate(0.000000,218.000000) scale(0.100000,-0.100000)"
                                                    fill="#000000" stroke="none">
                                                    <path d="M440 2062 c-19 -9 -44 -31 -55 -48 -11 -17 -35 -41 -53 -53 -18 -12
                                               -37 -32 -43 -44 -6 -13 -32 -32 -58 -44 -33 -16 -53 -34 -69 -61 l-22 -40 0
                                               -709 0 -710 23 -33 c12 -18 35 -43 50 -54 28 -21 30 -21 987 -21 957 0 959 0
                                               987 21 15 11 38 36 51 54 l22 33 0 710 0 709 -22 39 c-16 28 -37 46 -73 64
                                               -30 14 -56 34 -62 48 -7 14 -26 33 -42 43 -17 10 -34 26 -37 36 -8 27 -61 67
                                               -97 73 -24 5 -82 -8 -207 -44 -126 -36 -178 -47 -187 -39 -16 13 -43 3 -43
                                               -15 0 -15 -245 -88 -294 -87 -15 0 -176 43 -357 95 -180 52 -336 95 -346 95
                                               -10 0 -34 -8 -53 -18z m415 -127 c181 -52 330 -95 332 -95 2 0 3 -346 3 -770
                                               0 -424 -1 -770 -2 -770 -2 0 -167 43 -367 95 -307 79 -369 98 -390 120 l-26
                                               25 0 721 0 721 28 24 c17 15 41 24 61 24 17 0 180 -43 361 -95z m1110 71 c14
                                               -14 26 -41 30 -67 3 -24 5 -349 3 -721 l-3 -678 -25 -25 c-22 -21 -85 -41
                                               -385 -119 -198 -51 -363 -91 -367 -89 -5 2 -8 348 -8 768 0 719 1 764 18 769
                                               9 3 65 19 124 36 59 17 114 33 123 36 12 5 15 -1 15 -27 -1 -28 -8 -39 -40
                                               -61 -118 -82 -114 -265 7 -348 31 -22 33 -25 33 -84 -1 -60 -2 -62 -40 -88
                                               -118 -82 -114 -265 7 -348 32 -22 33 -25 33 -92 0 -54 3 -70 16 -75 23 -9 34
                                               15 34 75 l0 52 33 0 c164 0 270 172 195 317 -34 68 -92 106 -168 111 l-60 4 0
                                               44 0 44 40 0 c157 0 262 175 189 316 -35 67 -94 107 -169 112 -60 4 -60 5 -60
                                               36 l0 31 158 46 c186 55 233 59 267 25z m-1583 -1504 c29 -42 56 -53 261 -108
                                               111 -30 186 -52 167 -50 -216 28 -411 60 -438 72 -63 28 -62 11 -62 766 l0
                                               683 23 35 22 35 5 -705 c5 -635 7 -707 22 -728z m1706 683 c3 -769 5 -741 -61
                                               -770 -29 -13 -456 -80 -463 -72 -2 1 83 25 187 52 105 26 205 56 222 65 17 9
                                               39 32 49 51 17 32 18 75 18 724 l0 689 23 -22 22 -23 3 -694z m-1818 -27 c0
                                               -631 1 -686 18 -717 33 -65 52 -72 315 -112 l242 -37 -297 -1 -298 -1 -32 29
                                               -33 29 0 717 0 717 33 29 c18 16 37 29 42 29 7 0 10 -241 10 -682z m1912 653
                                               l33 -29 0 -717 0 -717 -33 -29 -32 -29 -298 1 -297 1 230 34 c241 35 283 48
                                               319 97 21 28 21 37 24 723 1 437 6 694 12 694 5 0 24 -13 42 -29z m-545 8 c38
                                               -14 83 -57 99 -96 55 -127 -65 -268 -196 -233 -48 13 -103 59 -120 100 -18 44
                                               -8 130 20 170 41 57 131 84 197 59z m38 -540 c19 -13 45 -43 56 -67 64 -131
                                               -55 -278 -194 -241 -45 12 -100 58 -117 99 -18 44 -8 130 20 170 50 70 161 89
                                               235 39z" />
                                                    <path d="M532 1788 c3 -7 123 -48 269 -90 239 -70 310 -85 283 -58 -9 9 -519
                                               160 -542 160 -8 0 -12 -6 -10 -12z" />
                                                    <path d="M532 1648 c6 -17 540 -170 552 -158 6 6 0 13 -15 20 -33 14 -509 150
                                               -527 150 -7 0 -12 -5 -10 -12z" />
                                                    <path d="M532 1518 c6 -18 539 -171 551 -159 7 7 1 14 -14 20 -34 15 -509 151
                                               -526 151 -8 0 -13 -5 -11 -12z" />
                                                    <path d="M535 1400 c-8 -13 0 -16 288 -99 220 -64 288 -77 260 -51 -7 7 -521
                                               160 -536 160 -3 0 -9 -5 -12 -10z" />
                                                    <path d="M535 1270 c-8 -13 6 -19 295 -102 226 -65 282 -76 254 -49 -7 8 -521
                                               161 -538 161 -3 0 -8 -5 -11 -10z" />
                                                    <path d="M535 1140 c-9 -14 15 -23 282 -100 250 -72 277 -78 271 -58 -3 8
                                               -517 167 -545 168 -1 0 -5 -4 -8 -10z" />
                                                    <path d="M535 1011 c-9 -15 15 -24 277 -100 253 -73 282 -79 276 -59 -2 6
                                               -125 47 -274 89 -314 92 -272 81 -279 70z" />
                                                    <path d="M534 889 c-3 -6 -4 -12 -1 -15 13 -13 548 -161 553 -152 3 5 4 12 1
                                               15 -3 2 -97 31 -209 64 -330 96 -337 98 -344 88z" />
                                                    <path d="M534 759 c-3 -6 -4 -13 -1 -15 13 -14 543 -160 551 -153 5 5 7 11 4
                                               15 -5 4 -342 105 -515 153 -21 6 -35 6 -39 0z" />
                                                    <path d="M1440 1609 c0 -20 77 -89 99 -89 30 0 26 17 -9 35 -16 8 -37 27 -46
                                               40 -17 26 -44 34 -44 14z" />
                                                    <path d="M1586 1544 c-8 -21 1 -34 24 -34 25 0 35 17 20 35 -16 20 -36 19 -44
                                               -1z" />
                                                    <path d="M1447 1094 c-10 -10 19 -59 45 -76 13 -8 33 -18 46 -22 35 -11 28 19
                                               -8 34 -17 7 -38 26 -47 41 -18 29 -25 34 -36 23z" />
                                                    <path d="M1590 1024 c-11 -12 -10 -18 3 -32 16 -15 18 -15 34 0 13 14 14 20 3
                                               32 -7 9 -16 16 -20 16 -4 0 -13 -7 -20 -16z" />
                                                </g>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </main>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
@endsection
