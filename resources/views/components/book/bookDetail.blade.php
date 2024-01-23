{{-- resources/views/components/book/bookDetail.blade.php --}}

@extends('layouts.app') {{-- Ajusta según la estructura de tu layout --}}

@section('content')

    <div class="container mt-5">
        <div class="text-center border border-dark bg-white p-4">
            <div class="mb-4">
                <h1 class="display-3 fw-bold text-primary">{{ $editionBook->title }}</h1>
                <h3 class="text-muted">{{ $editionBook->price > 0 ? $editionBook->price : "0,00" }} €</h3>
            </div>
            <div class="border-bottom border-primary mb-4"></div>
            <p class="lead text-dark">Descubre una nueva aventura literaria con {{ $editionBook->title }}.</p>
            <div class="d-flex justify-content-center">
                <div class="border-top border-dark w-25"></div>
            </div>
        </div>

        <div class="container mt-4">
            <div class="card border border-dark rounded">
                <div class="row g-0">
                    <div class="col-md-2 bg-light text-center py-3">
                        @if ($editionBook->for_adults)
                            <div class="badge bg-danger text-white mb-2">+18</div>
                        @endif
                        @if ($editionBook->self_published)
                            <div class="badge bg-primary text-white">Auto-publicado</div>
                        @endif
                        @if ($editionBook->cover)
                            <img src="{{ asset('storage/' . $editionBook->cover) }}" alt="Portada del Libro"
                                class="img-fluid rounded mt-1" style="max-width: 10vw">
                        @else
                            <div class="text-muted">No hay imagen disponible</div>
                        @endif
                    </div>
                    <div class="col-md-4 bg-white">
                        <div class="p-3">
                            <h4 class="mb-4">Géneros</h4>
                            <div class="d-flex flex-wrap">
                                @forelse ($editionBook->genres as $genre)
                                    <span class="badge bg-secondary me-2 mb-2">{{ $genre->genre_name }}</span>
                                @empty
                                    <p class="text-muted"><em>Este libro no tiene géneros asignados.</em></p>
                                @endforelse
                            </div>
                        </div>
                        <div class="p-3">
                            <h4 class="mb-4">Autores</h4>
                            <div class="d-flex flex-wrap">
                                @forelse ($editionBook->authors as $author)
                                    <span class="badge bg-dark me-2 mb-2">
                                        {{ $author->nickname ? $author->nickname : $author->surnames . ', ' . $author->name }}</span>
                                @empty
                                    <p class="text-muted">Anónimo</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 bg-light text-center py-4">
                        <p class="pe-4 text-justify">{{ $editionBook->description ?: 'Descripción no disponible' }}</p>
                    </div>
                </div>
            </div>
        </div>



        <div x-data="{ addedToFavorites: {{ json_encode($editionBook->isBookInFavorites($editionBook->id)) }} }">
            <div class="text-center rounded-bottom-1 border border-dark bg-white mt-3 mb-3 p-4">
                @auth
                    @if (!Auth::user()->isAdmin() && !Auth::user()->isSubadmin())
                        <div class="row mt-3 mb-3">
                            @if ($editionBook->for_adults)
                                @if (Auth::user()->isAdult())
                                    <div class="col-md-6 mb-3">
                                        <div class="d-flex align-items-center justify-content-center">
                                            @include('partials/add_remove_wishs')
                                        </div>
                                    </div>
                                    @if (!Auth::user()->hasPurchasedBook($editionBook->id))
                                        <div class="col-md-6">
                                            <form action="{{ route('shop.payment.stripe') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="price" value="{{ $editionBook->price }}">
                                                <input type="hidden" name="title" value="{{ $editionBook->title }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <input type="hidden" name="editionBook_id" value="{{ $editionBook->id }}">
                                                @if (auth()->check())
                                                    <input type="hidden" name="customer_name" value="{{ auth()->user()->name }}">
                                                @endif
                                                <button type="submit" class="btn btn-primary btn-lg">Comprar</button>
                                            </form>
                                        </div>
                                    @else
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <button x-show="!addedToFavorites" x-on:click.prevent="addToFavorites()"
                                                        class="btn btn-primary btn-lg">
                                                    Añadir a favoritos
                                                </button>
                                                <button x-show="addedToFavorites" x-on:click.prevent="removeFromFavorites()"
                                                        class="btn btn-danger btn-lg">
                                                    Quitar de favoritos
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    <div class="col-12">
                                        <p class="text-danger mb-3">Este libro no está recomendado para tu edad.</p>
                                        <p class="badge bg-danger text-white">+18</p>
                                    </div>
                                @endif
                            @else
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-center justify-content-center">
                                        @include('partials/add_remove_wishs')
                                    </div>
                                </div>
                                @if (!Auth::user()->hasPurchasedBook($editionBook->id))
                                    <div class="col-md-6">
                                        <form action="{{ route('shop.payment.stripe') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="price" value="{{ $editionBook->price }}">
                                            <input type="hidden" name="title" value="{{ $editionBook->title }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <input type="hidden" name="editionBook_id" value="{{ $editionBook->id }}">
                                            @if (auth()->check())
                                                <input type="hidden" name="customer_name" value="{{ auth()->user()->name }}">
                                            @endif
                                            <button type="submit" class="btn btn-primary btn-lg">Comprar</button>
                                        </form>
                                    </div>
                                @else
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <button x-show="!addedToFavorites" x-on:click.prevent="addToFavorites()"
                                                    class="btn btn-primary btn-lg">
                                                Añadir a favoritos
                                            </button>
                                            <button x-show="addedToFavorites" x-on:click.prevent="removeFromFavorites()"
                                                    class="btn btn-danger btn-lg">
                                                Quitar de favoritos
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                    @endif
                @endauth
                @guest
                    <div class="alert alert-warning text-center mb-4">
                        <strong>Debes estar registrado/logueado para realizar acciones en la web.</strong>
                    </div>
                    <div class="text-center mt-3 mb-3">
                        <a class="btn btn-outline-primary mx-2 btn-lg" href="{{ route('login') }}">Iniciar Sesión</a>
                        <a class="btn btn-outline-success mx-2 btn-lg" href="{{ route('register') }}">Registrarse</a>
                    </div>
                @endguest
            </div>
        </div>



        <div>
            @include('partials/book_comments', ['comments' => $comments, 'book' => $editionBook])
        </div>
    </div>


    <script src="http://unpkg.com/alpinejs@3.4.2/dist/sdn.min.js"></script>
    <script>
        function addToFavorites() {
            axios.post(`/favorites/add/{{ $editionBook->id }}`)
                .then(response => {
                    if (response.data.success) {
                        Alpine.data('addedToFavorites', true);
                        window.location.reload();
                    }
                });
        }

        function removeFromFavorites() {
            axios.post(`/favorites/remove/{{ $editionBook->id }}`)
                .then(response => {
                    if (response.data.success) {
                        Alpine.data('addedToFavorites', false);
                        window.location.reload();
                    }
                });
        }
    </script>

@endsection
