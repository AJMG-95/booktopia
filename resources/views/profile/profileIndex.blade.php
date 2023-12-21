<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row ">
            <aside class="col-auto ">
                <div id="sidebar" class="collapse collapse-horizontal show border-end">
                    <div id="sidebar-nav" class="list-group border-0 rounded-0 text-sm-start min-vh-99">
                        <a href="#" class="list-group-item border-end-0 d-inline-block text-truncate"
                            data-bs-parent="#sidebar"><i class="bi bi-bootstrap"></i> <span>Mis publicaciones</span> </a>
                        <a href="#" class="list-group-item border-end-0 d-inline-block text-truncate"
                            data-bs-parent="#sidebar"><i class="bi bi-film"></i> <span>Mi lista de deseos</span></a>
                        <a href="#" class="list-group-item border-end-0 d-inline-block text-truncate"
                            data-bs-parent="#sidebar"><i class="bi bi-heart"></i> <span>Mi lista de favoritos</span></a>
                        <a href="#" class="list-group-item border-end-0 d-inline-block text-truncate"
                            data-bs-parent="#sidebar"><i class="bi bi-bricks"></i> <span>Mis comentarios</span></a>
                        <a href="#" class="list-group-item border-end-0 d-inline-block text-truncate"
                            data-bs-parent="#sidebar"><i class="bi bi-clock"></i> <span>Mis post</span></a>
                        <a href="#" class="list-group-item border-end-0 d-inline-block text-truncate"
                            data-bs-parent="#sidebar"><i class="bi bi-envelope"></i> <span>Mis Notificaciones</span></a>
                    </div>
                </div>
            </aside>
            <main class="col-9 ps-md-2 pt-2">
                <a href="#" data-bs-target="#sidebar" data-bs-toggle="collapse"
                    class="border rounded-3 p-1 text-decoration-none"><i class="bi bi-list bi-lg py-2 p-1"></i> Menu</a>
                <div class="page-header pt-3">
                    <h2>{{ Auth::user()->name }}</h2>
                </div>
                {{-- <p class="lead">A offcanvas "push" vertical nav menu example.</p> --}}
                <hr>


                <div class="card">
                    <div class="card-header">
                        Información del Usuario
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"></h5>
                        <p class="card-text">Correo Electrónico: {{ Auth::user()->email }}</p>
                        {{-- Agrega más campos según la migración user --}}
                    </div>
                </div>
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



            </main>
        </div>
    </div>
@endsection

</body>
</html>
