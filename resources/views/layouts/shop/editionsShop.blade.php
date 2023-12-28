{{-- resources/views/layouts/shop/editionsShop.blade.php --}}
@extends('layouts.app')

@section('content')
<style>
    /* Colores principales */
    body {
        background-color: #005f40; /* Verde oscuro */
        color: #ffffff; /* Texto blanco sobre fondo oscuro */
    }

    /* Barra de navegación */
    .navbar {
        background-color: #00274e; /* Azul oscuro */
    }

    /* Botones y enlaces principales */
    .btn-primary,
    .btn-primary:hover,
    .btn-primary:active,
    .btn-primary:focus,
    .btn-secondary,
    .btn-secondary:hover,
    .btn-secondary:active,
    .btn-secondary:focus {
        background-color: #ffc107; /* Amarillo */
        border-color: #ffc107; /* Amarillo */
        color: #000000; /* Texto negro sobre fondo amarillo */
    }

    /* Botones de resaltado (eliminar, añadir, etc.) */
    .btn-danger,
    .btn-danger:hover,
    .btn-danger:active,
    .btn-danger:focus,
    .btn-dark,
    .btn-dark:hover,
    .btn-dark:active,
    .btn-dark:focus {
        background-color: #ff0000; /* Rojo */
        border-color: #ff0000; /* Rojo */
        color: #ffffff; /* Texto blanco sobre fondo rojo */
    }

    /* Detalles resaltados en negro */
    .text-black {
        color: #000000;
    }

    /* Detalles resaltados en rojo */
    .text-red {
        color: #ff0000;
    }

    /* Detalles resaltados en amarillo */
    .text-yellow {
        color: #ffc107;
    }

    /* Detalles resaltados en verde */
    .text-green {
        color: #005f40;
    }
</style>
    <div class="container-fluid">
        <div class="row">
            {{-- Menú lateral de filtros --}}
            <aside class="col-lg-3 col-md-4 pt-4">
                <h2>Buscar...</h2>
                <form action="{{ route('shop') }}" method="GET" class="p-3">
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
                        <a href="{{ route('shop') }}" class="btn btn-secondary btn-block">Borrar Filtros</a>
                    </div>
                </form>
            </aside>

            {{-- Área principal para mostrar los libros --}}
            <main class="col-lg-9 col-md-8 pt-4">
                <form action="{{ route('shop') }}" method="GET" class="me-2">
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
                    @foreach ($editions as $edition)
                        <div class="col">
                            <div class="card h-100">
                                <img src="{{ $edition->cover ? asset('assets/images/editionCovers/' . $edition->cover) : 'No Image' }}"
                                    class="card-img-top" alt="{{ $edition->title }}">
                                <div class="card-body">
                                    <h5>{{ $edition->title }}</h5>
                                    <p class="card-text">
                                        <strong>Autor:</strong>
                                        @if ($edition->book->authors->isNotEmpty())
                                            {{ $edition->book->authors->first()->name }}
                                        @else
                                            Sin autor
                                        @endif
                                    </p>
                                    <p class="card-text">
                                        <strong>Género:</strong>
                                        @if ($edition->book->genres->isNotEmpty())
                                            {{ $edition->book->genres->first()->genre }}
                                        @else
                                            Sin género
                                        @endif
                                    </p>
                                    <p class="card-text">{{ $edition->short_description }} </p>
                                </div>
                                @auth
                                    @if (!Auth::user()->isAdmin() && !Auth::user()->isSubadmin())
                                        <div class="card-footer row">
                                            @php
                                                // Verificar si la edición está en la lista de deseos del usuario actual
                                                $isInWishlist = Auth::user()->wishes->contains('edition_id', $edition->id);
                                            @endphp

                                            @if ($isInWishlist)
                                                <!-- Si está en la lista de deseos, mostrar botón para eliminar -->
                                                <form action="{{ route('wishes.remove', ['id' => $edition->id]) }}"
                                                    method="POST" >
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn "><svg width="2.5vw" height="auto"
                                                            viewBox="0 0 24.00 24.00" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            transform="rotate(-45)matrix(1, 0, 0, 1, 0, 0)" stroke="#000000"
                                                            stroke-width="0.672">
                                                            <g id="SVGRepo_bgCarrier" stroke-width="0"
                                                                transform="translate(1.92,1.92), scale(0.84)">
                                                                <rect x="0" y="0" width="24.00" height="24.00"
                                                                    rx="12" fill="#eec42b" strokewidth="0"></rect>
                                                            </g>
                                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke="#CCCCCC"
                                                                stroke-width="0.144"></g>
                                                            <g id="SVGRepo_iconCarrier">
                                                                <path
                                                                    d="M14.65 8.93274L12.4852 4.30901C12.2923 3.89699 11.7077 3.897 11.5148 4.30902L9.35002 8.93274L4.45559 9.68243C4.02435 9.74848 3.84827 10.2758 4.15292 10.5888L7.71225 14.2461L6.87774 19.3749C6.80571 19.8176 7.27445 20.1487 7.66601 19.9317L12 17.5299L16.334 19.9317C16.7256 20.1487 17.1943 19.8176 17.1223 19.3749L16.2878 14.2461L19.8471 10.5888C20.1517 10.2758 19.9756 9.74848 19.5444 9.68243L14.65 8.93274Z"
                                                                    stroke="#000000" stroke-linecap="round"
                                                                    stroke-linejoin="round"></path>
                                                            </g>
                                                        </svg></button>
                                                </form>
                                            @else
                                                <!-- Si no está en la lista de deseos, mostrar botón para añadir -->
                                                <form action="{{ route('wishes.add', ['id' => $edition->id]) }}"
                                                    method="POST" class="col">
                                                    @csrf
                                                    <button type="submit" class="btn ">
                                                        <svg viewBox="0 0 24 24" fill="none" width="2.5vw"
                                                            height="auto" xmlns="http://www.w3.org/2000/svg">
                                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                                stroke-linejoin="round"></g>
                                                            <g id="SVGRepo_iconCarrier">
                                                                <path
                                                                    d="M14.65 8.93274L12.4852 4.30901C12.2923 3.89699 11.7077 3.897 11.5148 4.30902L9.35002 8.93274L4.45559 9.68243C4.02435 9.74848 3.84827 10.2758 4.15292 10.5888L7.71225 14.2461L6.87774 19.3749C6.80571 19.8176 7.27445 20.1487 7.66601 19.9317L12 17.5299L16.334 19.9317C16.7256 20.1487 17.1943 19.8176 17.1223 19.3749L16.2878 14.2461L19.8471 10.5888C20.1517 10.2758 19.9756 9.74848 19.5444 9.68243L14.65 8.93274Z"
                                                                    stroke="#000000" stroke-linecap="round"
                                                                    stroke-linejoin="round"></path>
                                                            </g>
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif

                                            <form action="{{ route('edition.show', ['id' => $edition->id]) }}" method="GET"
                                                class="col">
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
                                    @endif
                                @endauth
                            </div>
                        </div>
                    @endforeach
                </div>
            </main>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        function toggleWishes(editionId) {
            var checkbox = document.getElementById('wishes' + editionId);

            // Realiza una solicitud AJAX para agregar o eliminar la edición de la lista de deseos
            fetch(`/wishes/toggle/${editionId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        editionId: editionId
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        console.log(data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
@endsection
