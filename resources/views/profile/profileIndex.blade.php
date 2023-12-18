@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-4">
        <div class="row">
            {{-- Aside with links --}}
            <aside class="col-md-3">
                <ul class="list-group">
                    <li class="list-group-item"><a href="#my-posts">Mis publicaciones</a></li>
                    <li class="list-group-item"><a href="#wish-list">Mi lista de deseos</a></li>
                    <li class="list-group-item"><a href="#favorites">Mi lista de favoritos</a></li>
                    <li class="list-group-item"><a href="#my-comments">Mis comentarios</a></li>
                    <li class="list-group-item"><a href="#my-posts">Mis posts</a></li>
                </ul>
            </aside>

            {{-- User information card --}}
            <!-- User information card -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        Información del Usuario
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ Auth::user()->name }}</h5>
                        <p class="card-text">Correo Electrónico: {{ Auth::user()->email }}</p>
                        {{-- Agrega más campos según la migración user --}}
                    </div>
                </div>

                {{-- Wishlist Carousel --}}
                <div id="carouselWishlist" class="carousel slide mt-4" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @forelse ($wishlistBooks as $wishlistBook)
                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Libro en la Lista de Deseos</h5>
                                        <!-- Mostrar información de la edición -->
                                        <p>Edición: {{ $wishlistBook->edition->title }}</p>
                                        <p>Descripción: {{ $wishlistBook->edition->description }}</p>
                                        <!-- Otras propiedades de la edición -->
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p>No hay libros en tu lista de deseos.</p>
                        @endforelse
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselWishlist"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselWishlist"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

        </div>
    </div>
@endsection
