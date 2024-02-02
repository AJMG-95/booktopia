{{-- resources/views/layouts/shop/editionsShop.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container-fluid ms-0 me-0 px-3 py-3 mt-2">
        <div class="ms-3 mb-4 text-center p-2" style="background-color:rgba(247, 247, 247, 0.651)">
            <h1 class="display-4 fw-bold" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);">
                <img src="{{ asset('assets/images/logos/logo2.png') }}" alt="Logo" style="max-height: 10vh">
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
                <form action="{{ route('books.search') }}" method="GET">
                    <!-- ... otros campos ... -->
                    <div class="d-flex justify-content-left align-items-center mb-4">
                        <select name="sortBy" class="form-select w-auto">
                            <option value="asc_price" @if (request('sortBy') == 'asc_price') selected @endif>Mayor a menor €
                            </option>
                            <option value="desc_price" @if (request('sortBy') == 'desc_price') selected @endif>Menor a mayor €
                            </option>
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
                <div class="row ">
                    @if ($books->isEmpty())
                        <div class="alert alert-info col-12 text-center">
                            <h4>
                                No se encontraron libros con los filtros aplicados.
                            </h4>
                        </div>
                    @else
                        <div class="col-12 row">
                            @foreach ($books as $book)
                                <div class="col-3 mb-4">
                                    <div class="card border border-black rounded p-1 mx-4 mb-4"
                                        style="max-width: 15vw; background-color:rgba(247, 247, 247, 0.651); min-height:52vh; max-height:52vh">
                                        <div class="card-header text-center">
                                            <h5>{{ $book->title }}</h5>
                                        </div>
                                        <div class="card-body text-center">
                                            <div style="max-width: 150px; max-height: 22vh; margin: auto;"
                                                class="mt-1 border rounded-1 mb-2 overflow-hidden">
                                                <img src="{{ asset('storage/' . $book->cover) }}"
                                                    class="card-img-top rounded-1 img-fluid" alt="{{ $book->title }}"
                                                    style="object-fit: cover;">
                                            </div>
                                            <div style="max-width: 150px; max-height: 22vh; margin: auto;"
                                                class="text-center justify-content-end">

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
                                                </p>
                                                <p class="card-text">
                                                    <strong>Precio:</strong>
                                                    @auth
                                                        {{ Auth::user()->isSubscriber() ? number_format($book->price * 0.8, 2, ',', '.') : number_format($book->price, 2, ',', '.') }}
                                                        €
                                                    @endauth
                                                    @guest()
                                                        {{ number_format($book->price, 2, ',', '.') }} €
                                                    @endguest
                                                </p>
                                            </div>
                                        </div>
                                        <div class="card-footer text-center">
                                            <div class="row">
                                                <div class="col-auto mx-auto">
                                                    <a href="{{ route('books.details', $book->id) }}"
                                                        class="btn btn-primary">
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
                                </div>
                            @endforeach
                        </div>
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
