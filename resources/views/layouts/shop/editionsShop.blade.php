{{-- resources/views/layouts/shop/editionsShop.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container-fluid p-2 mt-4" style="width: 100%">
        <div class="row" style="width: 100%">
            <aside class="col-lg-3 col-md-4 col-sm-5 pt-4">
                <h2>Buscar...</h2>
                {{-- Buscador: --}}
                <form action="{{ route('books.shop') }}" method="GET" class="p-3">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" name="title" class="form-control" placeholder="Buscar por Título"
                            {{--   value="{{ old('title', $request->get('title')) }}" --}} />
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" name="author" class="form-control" placeholder="Buscar por Autor"
                            {{--  value="{{ old('author', $request->get('author')) }}"  --}} />
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="bi bi-list"></i></span>
                        <input list="genres" name="genre" class="form-control" placeholder="Buscar por Género"
                            {{-- value="{{ old('genre', $request->get('genre')) }}" --}} />
                        <datalist id="genres">
                            @foreach ($genres as $genre)
                                <option value="{{ $genre->genre }}">
                            @endforeach
                        </datalist>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">(max.) €</span>
                        <input type="number" name="max_price" class="form-control" {{--  value="{{ old('max_price', $request->get('max_price')) }}" --}} />
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">(min.) €</span>
                        <input type="number" name="min_price" class="form-control" {{--  value="{{ old('min_price', $request->get('min_price')) }}" --}} />
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="bi bi-upc-scan"></i></span>
                        <input type="text" name="isbn" class="form-control" placeholder="ISBN"
                            {{-- value="{{ old('isbn', $request->get('isbn')) }}" --}} />
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="bi bi-globe"></i></span>
                        <input list="languages" name="language" class="form-control" placeholder="Seleccionar Idioma"
                            {{--    value="{{ old('language', $request->get('language')) }}" --}}>
                        <datalist id="languages">
                            @foreach ($languages as $language)
                                <option value="{{ $language->iso_code }}">{{ $language->language }}</option>
                            @endforeach
                        </datalist>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="autopublicado" value="0" class="form-check-input"
                            {{--  {{ old('autopublicado', $request->get('autopublicado')) == '0' ? 'checked' : '' }} --}}>
                        <label for="autopublicado">Mostrar solo libros autopublicados</label>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-block">Aplicar Filtros</button>
                    </div>
                    <div class="d-grid gap-2 mt-3">
                        <a href="{{ route('books.shop') }}" class="btn btn-secondary btn-block">Borrar Filtros</a>
                    </div>
                </form>
            </aside>


            <main class="col-lg-9 col-md-8 col-ms-7 pt-4">
                {{-- Ordenar por: --}}
                <form action="{{ route('books.shop') }}" method="GET">
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
                        <button type="submit" class="btn btn-primary ms-2">Ordenar</button>
                    </div>
                </form>
                {{-- Área para mostrar los libros --}}
                <div class="row row-cols-1 row-cols-md-3 pe-4">
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
                            </div>
                            <div class="card-footer row text-center">
                                <div class="col-auto">
                                    <a href="{{ route('books.show', $book->id) }}" class="btn btn-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </div>
                                @auth
                                    @if (!Auth::user()->isAdmin() && !Auth::user()->isSubadmin())
                                        <div class="col-5">
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
                                                <form action="{{ route('wishes.remove', ['id' => $book->id]) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"><i
                                                            class="bi bi-bookmark-fill"></i></button>
                                                </form>
                                            @endif
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
@endsection
