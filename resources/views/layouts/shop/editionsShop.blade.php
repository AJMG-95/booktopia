{{-- resources/views/layouts/shop/editionsShop.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container-fluid ms-0 me-0 px-3 py-3 mt-2">
        <div class="ms-3 mb-4 text-center p-2" style="background-color:rgba(247, 247, 247, 0.651)">
            <h1 class="display-4 fw-bold" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);">
                <img src="{{ asset('assets/images/logos/logo2.png') }}" alt="Logo" style="max-height: 10vh"
                    class="img-fluid">
                <ins>
                    Bienvenido a la tienda
                </ins>
            </h1>
        </div>
        <div class="row">
            {{-- Menú lateral de filtros --}}
            <aside class="col-lg-3 col-md-4 pt-4">
                <h2>Buscar...</h2>
                <form action="{{ route('books.search') }}" method="GET" class="p-3">
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
                    <div class="input-group mb-3">
                        <span class="input-group-text">(max.) €</span>
                        <input type="text" name="max_price" class="form-control" step="0.01"
                            placeholder="Precio máximo" min="0"
                            value="{{ old('max_price', request('max_price')) }}" />
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">(min.) €</span>
                        <input type="text" name="min_price" class="form-control" step="0.01"
                            placeholder="Precio mínimo" min="0" max="9999"
                            value="{{ old('min_price', request('min_price')) }}" />
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
                    @auth
                        @if (Auth::user()->isAdult())
                            <div class="mb-3 form-check">
                                <input type="checkbox" name="for_adults" value="1" class="form-check-input"
                                    @if (old('for_adults', request('for_adults'))) checked @endif>
                                <label for="for_adults" class="form-check-label">Solo libros para adultos</label>
                            </div>
                        @else
                            <input type="hidden" name="for_adults" value="0">
                        @endif
                    @endauth



                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-block" id="searchBtn">
                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            Aplicar Filtros
                        </button>
                        <a href="{{ route('books.search') }}" class="btn btn-primary btn-block mt-2">
                            Borrar Filtros
                        </a>
                    </div>
                </form>

            </aside>

            {{-- Área principal para mostrar los libros --}}
            <main class="col-lg-9 col-md-8 col-ms-7 pt-4">
                {{-- Ordenar por: --}}
                <form action="{{ route('books.search') }}" method="GET" class="w-50">
                    <!-- ... otros campos ... -->
                    <div class="mb-4">
                        <div class="row align-items-end">
                            <div class="col-md-6 col-lg-3 ">
                                <label for="sortBy" class="form-label d-block">Ordenar por:</label>
                                <select name="sortBy" id="sortBy" class="form-select">
                                    <option value="asc_price" @if (request('sortBy') == 'asc_price') selected @endif>Mayor a menor €</option>
                                    <option value="desc_price" @if (request('sortBy') == 'desc_price') selected @endif>Menor a mayor €</option>
                                    <option value="asc_title" @if (request('sortBy') == 'asc_title') selected @endif>A-Z</option>
                                    <option value="desc_title" @if (request('sortBy') == 'desc_title') selected @endif>Z-A</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-lg-3 ">
                                <label for="orderDirection" class="form-label d-block">Dirección:</label>
                                <select name="orderDirection" id="orderDirection" class="form-select">
                                    <option value="desc" @if (request('orderDirection', 'desc') == 'desc') selected @endif>Más reciente a más antiguo</option>
                                    <option value="asc" @if (request('orderDirection') == 'asc') selected @endif>Más antiguo a más reciente</option>
                                </select>
                            </div>
                            <div class="col-md-12 col-lg-6 mt-md-0 ">
                                <button type="submit" class="btn btn-primary w-50">Ordenar</button>
                            </div>
                        </div>
                    </div>
                </form>


                {{-- Área para mostrar los libros --}}
                <div class="d-flex flex-wrap justify-content-center">
                    @if ($books->isEmpty())
                        <div class="alert alert-info col-12 text-center">
                            <h4>
                                No se encontraron libros con los filtros aplicados.
                            </h4>
                        </div>
                    @else
                        @foreach ($books as $book)
                            <div class="card border border-black rounded p-1 mx-2 mb-4 col-lg-3 col-md-4 col-sm-6 col-xs-12"
                                style="background-color: rgba(247, 247, 247, 0.651); min-height: 57vh; max-height: 57vh">
                                <div class="card-header text-center">
                                    <h5>{{ $book->title }}</h5>
                                </div>
                                <div class="card-body text-center d-flex flex-column align-items-center">
                                    <div id="card-body-img" style="width: 150px; height: 22vh;"
                                        class="border rounded-1 overflow-hidden mb-3">
                                        <img src="{{ asset('storage/' . $book->cover) }}" class="card-img-top rounded-1 img-fluid"
                                            alt="{{ $book->title }}" style="object-fit: cover; width: 100%; height: 100%;">
                                    </div>
                                    <div id="card-body-text" style="width: 150px; max-height: 22vh;"
                                        class="text-center justify-content-end">
                                        <p class="card-text mb-1">
                                            <strong>Autor:</strong>
                                            @if ($book->authors->isNotEmpty())
                                                {{ $book->authors->first()->name }}
                                            @else
                                                Sin autor
                                            @endif
                                        </p>
                                        <p class="card-text mb-1">
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
                                        </p>
                                        <p class="card-text mb-0">
                                            <strong>Precio:</strong>
                                            @auth
                                                {{ Auth::user()->isSubscriber() ? number_format($book->price * 0.8, 2, ',', '.') : number_format($book->price, 2, ',', '.') }}
                                                €
                                            @endauth
                                            @guest
                                                {{ number_format($book->price, 2, ',', '.') }} €
                                            @endguest
                                        </p>
                                    </div>
                                </div>
                                <div class="card-footer text-center">
                                    <div class="row m-0">
                                        <div class="col-auto mx-auto">
                                            <a href="{{ route('books.details', $book->id) }}" class="btn btn-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </div>
                                        <div class="col-6">
                                            @auth
                                                @if (!Auth::user()->isAdmin() && !Auth::user()->isSubadmin())
                                                    <div class="col-5 mx-auto">
                                                        @include('partials/add_remove_wishs')
                                                    </div>
                                                @endif
                                            @endauth
                                        </div>
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
