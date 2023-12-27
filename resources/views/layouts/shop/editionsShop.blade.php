{{-- resources/views/layouts/shop/editionsShop.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            {{-- Menú lateral de filtros --}}
            <aside class="col-lg-3 col-md-4 pt-4">
                <h2>Buscar...</h2>
                <form action="{{ route('shop') }}" method="GET" class="p-3">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" name="title" class="form-control" placeholder="Buscar por Título" />
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" name="author" class="form-control" placeholder="Buscar por Autor">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="bi bi-bookmark"></i></span>
                        <input type="text" name="genre" class="form-control" placeholder="Buscar por Genero">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">(max.) €</span>
                        <input type="number" name="max_price" class="form-control">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">(min.) €</span>
                        <input type="number" name="min_price" class="form-control">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="bi bi-upc-scan"></i></span>
                        <input type="text" name="isbn" class="form-control" placeholder="ISBN">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="autopublicado" value="0" class="form-check-input">
                        <label for="autopublicado">Mostrar solo libros autopublicados</label>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-block"> Aplicar Filtros </button>
                    </div>
                </form>
            </aside>

            {{-- Área principal para mostrar los libros --}}
            <main class="col-lg-9 col-md-8 pt-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <select name="shortBy" class="form-select w-auto">
                        <option value="asc_price">Menor a mayorg €</option>
                        <option value="desc_price">Mayor a menor €</option>
                        <option value="asc_title">A-Z</option>
                        <option value="desc_title">Z-A</option>
                        <option value="publication_date">Más reciente</option>
                    </select>
                </div>
                <div class="row row-cols-1 row-cols-md-3 g4">
                    @foreach ($editions as $edition)
                        <div class="col">
                            <div class="card h-100">
                                <img src="{{ $edition->cover }}" class="card-img-top" alt="{{ $edition->title }}">
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
                                                    method="POST" class="col">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"><i
                                                            class="bi bi-balloon-heart-fill"></i></button>
                                                </form>
                                            @else
                                                <!-- Si no está en la lista de deseos, mostrar botón para añadir -->
                                                <form action="{{ route('wishes.add', ['id' => $edition->id]) }}" method="POST" class="col">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary"><i
                                                            class="bi bi-balloon-heart"></i></button>
                                                </form>
                                            @endif

                                            <form action="{{ route('edition.show', ['id' => $edition->id]) }}" method="GET" class="col">
                                                @csrf
                                                <button type="submit" class="btn btn-success"><i class="bi bi-eye"></i> / <i class="bi bi-basket"></i></button>
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
