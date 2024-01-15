{{-- resources/views/components/book/bookDetail.blade.php --}}

@extends('layouts.app') {{-- Ajusta según la estructura de tu layout --}}

@section('content')
    <div class="container  mt-5 ">

        <div class="text-center rounded-top-1 border border-black bg-white">

            <h1>{{ $editionBook->title }}</h1>
            <h3>{{ $editionBook->price }} €</h3>
        </div>
        <div class="text-center border border-black bg-white">
            <div class=" row mt-4">
                <div class=" col-md-2 ">
                    @if (isset($editionBook) && $editionBook->cover)
                        <img src="{{ asset('storage/' . $editionBook->cover) }}" alt="Imagen del Género" class="rounded "
                            style="max-height: 25vh">
                    @else
                        No imagen
                    @endif
                </div>

                <div class=" col-md-4 row">

                    <div class="col-12 row">
                        <div class="col-6">
                            <h4>Géneros</h4>
                        </div>
                        <div class="col-12">
                            <div class="d-flex flex-row">
                                @forelse ($editionBook->genres as $key => $genre)
                                    <p class="me-1">{{ $genre->genre_name }}{{ !$loop->last ? ',' : '.' }}</p>
                                @empty
                                    <p><em>Este libro no tiene géneros asignados.</em></p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="col-12 row">
                        <div class="col-6">
                            <h4>Autores</h4>
                        </div>
                        <div class="col-12">
                            <div class="d-flex flex-row">
                                @forelse ($editionBook->authors as $key => $author)
                                    <p class="me-4">{{ $author->name }}{{ !$loop->last ? ',' : '.' }}</p>
                                @empty
                                    <p>Anonimo</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="col-12 row mt-4 mb-3 items-center">
                        <div class="col-6">
                            <p name="self_publish" id="self_publish" class=" ms-4">
                                {{ $editionBook->self_published ? 'Auto-publicado' : '' }}</p>
                        </div>
                        <div class="col-6">
                            @if ($editionBook->for_adults)
                                <svg width="2vw" height="2vw" viewBox="-2.4 -2.4 28.80 28.80" id="Layer_1"
                                    data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" fill="#000000" stroke="#000000">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0">
                                        <rect x="-2.4" y="-2.4" width="28.80" height="28.80" rx="14.4" fill="#ffffff"
                                            strokewidth="0"></rect>
                                    </g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <defs>
                                            <style>
                                                .cls-1 {
                                                    fill: none;
                                                    stroke: #ff0000;
                                                    stroke-miterlimit: 10;
                                                    stroke-width: 1.91px;
                                                }
                                            </style>
                                        </defs>
                                        <path class="cls-1" d="M19.45,19.42a10.5,10.5,0,1,1,0-14.84"></path>
                                        <rect class="cls-1" x="11.07" y="8.18" width="4.77" height="3.82"
                                            rx="1.91"></rect>
                                        <rect class="cls-1" x="11.07" y="12" width="4.77" height="3.82" rx="1.91">
                                        </rect>
                                        <line class="cls-1" x1="7.25" y1="7.23" x2="7.25" y2="15.82">
                                        </line>
                                        <line class="cls-1" x1="5.34" y1="15.82" x2="9.16" y2="15.82">
                                        </line>
                                        <line class="cls-1" x1="5.34" y1="9.14" x2="8.2" y2="9.14">
                                        </line>
                                        <line class="cls-1" x1="17.75" y1="12" x2="23.48" y2="12">
                                        </line>
                                        <line class="cls-1" x1="20.61" y1="9.14" x2="20.61" y2="14.86">
                                        </line>
                                    </g>
                                </svg>
                            @endif
                        </div>

                    </div>
                </div>
                <div class=" col-md-6 p-4 text-center">
                    <p class=" pe-4 text-center">
                        {{ $editionBook->description ? $editionBook->description : 'Descripción' }}
                    </p>
                </div>

            </div>
        </div>
        <div x-data="{ addedToFavorites: {{ json_encode($editionBook->isBookInFavorites($editionBook->id)) }} }">
            <div class="text-center  rounded-bottom-1 border border-black bg-white">
                @auth
                    @if (!Auth::user()->isAdmin() && !Auth::user()->isSubadmin())
                        <div class="row mt-3 mb-3">
                            @if ($editionBook->for_adults)
                                @if (Auth::user()->isAdult())
                                    <div class="col-6">
                                        @include('partials/add_remove_wishs')
                                    </div>
                                    @if (!Auth::user()->hasPurchasedBook($editionBook->id))
                                        <div class="col-6">
                                            <form action="{{ route('shop.payment.stripe') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="price" value="{{ $editionBook->price }}">
                                                <input type="hidden" name="title" value="{{ $editionBook->title }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <input type="hidden" name="editionBook_id" value="{{ $editionBook->id }}">

                                                <!-- Include customer details if available -->
                                                @if (auth()->check())
                                                    <input type="hidden" name="customer_name"
                                                        value="{{ auth()->user()->name }}">
                                                @endif

                                                <button type="submit" class="btn btn-primary">Comprar</button>

                                            </form>
                                        </div>
                                    @else
                                        <div class="col-6" x-show="!addedToFavorites">
                                            <a href="#" x-on:click.prevent="addToFavorites()"
                                                x-bind:aria-label="`Añadir ${editionBook.title} a favoritos`" class="btn btn-primary">
                                                Añadir a favoritos
                                            </a>
                                        </div>
                                        <div class="col-6" x-show="addedToFavorites">
                                            <a href="#" x-on:click.prevent="removeFromFavorites()"
                                                x-bind:aria-label="`Quitar ${editionBook.title} de favoritos`" class="btn btn-danger">
                                                Quitar de favoritos
                                            </a>
                                        </div>
                                    @endif
                                @else
                                    <p class="text-danger">Este libro no está reomendado para tu edad.</p>
                                @endif
                            @else
                                <div class="col-6">
                                    @include('partials/add_remove_wishs')
                                </div>
                                @if (!Auth::user()->hasPurchasedBook($editionBook->id))
                                    <div class="col-6">
                                        <form action="{{ route('shop.payment.stripe') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="price" value="{{ $editionBook->price }}">
                                            <input type="hidden" name="title" value="{{ $editionBook->title }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <input type="hidden" name="editionBook_id" value="{{ $editionBook->id }}">

                                            <!-- Include customer details if available -->
                                            @if (auth()->check())
                                                <input type="hidden" name="customer_name"
                                                    value="{{ auth()->user()->name }}">
                                            @endif

                                            <button type="submit" class="btn btn-primary">Comprar</button>

                                        </form>
                                    </div>
                                @else
                                    <div class="col-6" x-show="!addedToFavorites">
                                        <a href="#" x-on:click.prevent="addToFavorites()"
                                            x-bind:aria-label="`Añadir ${editionBook.title} a favoritos`" class="btn btn-primary">
                                            Añadir a favoritos
                                        </a>
                                    </div>
                                    <div class="col-6" x-show="addedToFavorites">
                                        <a href="#" x-on:click.prevent="removeFromFavorites()"
                                            x-bind:aria-label="`Quitar ${editionBook.title} de favoritos`" class="btn btn-danger">
                                            Quitar de favoritos
                                        </a>
                                    </div>
                                @endif
                            @endif

                        </div>
                    @endif
                @endauth
                @guest
                    <div class="alert alert-warning text-center">
                        <strong>Debes estar registrado/logueado para realizar acciones en la web.</strong>
                    </div>
                    <div class="text-center mt-3 mb-3">
                        <a class="btn btn-outline-primary mx-2" href="{{ route('login') }}">Iniciar Sesión</a>
                        <a class="btn btn-outline-success mx-2" href="{{ route('register') }}">Registrarse</a>
                    </div>
                @endguest
            </div>
        </div>
    </div>
    <script src="http://unpkg.com/alpinejs@3.4.2/dist/sdn.min.js"></script>
    <script>
        function addToFavorites() {
            axios.post(`/favorites/add/{{ $editionBook->id }}`)
                .then(response => {
                    if (response.data.success) {
                        Alpine.data('addedToFavorites', true);
                        window.location.reload(); // Recargar la página después de agregar a favoritos
                    }
                });
        }

        function removeFromFavorites() {
            axios.post(`/favorites/remove/{{ $editionBook->id }}`)
                .then(response => {
                    if (response.data.success) {
                        Alpine.data('addedToFavorites', false);
                        window.location.reload(); // Recargar la página después de quitar de favoritos
                    }
                });
        }
    </script>

@endsection
