@extends('layouts.app')


@section('content')
    <div class="container-fluid">
        <div class="row m-0">
            <div class="col-3 me-2 row ">
                <div class="col-auto  ">
                    <div id="sidebar" class="collapse collapse-horizontal show border-end pb-5 bg-white">
                        <div id="sidebar-nav"
                            class="list-group border-0 rounded-0 text-sm-start d-flex flex-column">
                            <a href="#" class="list-group-item border-end-0 d-inline-block text-truncate">
                                <i class="bi bi-film"></i> <span>Mi lista de deseos</span>
                            </a>
                            <a href="#" class="list-group-item border-end-0 d-inline-block text-truncate">
                                <i class="bi bi-heart"></i> <span>Mi lista de favoritos</span>
                            </a>
                            <a href="#" class="list-group-item border-end-0 d-inline-block text-truncate">
                                <i class="bi bi-bricks"></i> <span>Mis comentarios</span>
                            </a>
                            <a href="#" class="list-group-item border-end-0 d-inline-block text-truncate">
                                <i class="bi bi-clock"></i> <span>Mis post</span>
                            </a>
                            <a href="#" class="list-group-item border-end-0 d-inline-block text-truncate">
                                <i class="bi bi-envelope"></i> <span>Mis Notificaciones</span>
                            </a>
                            @if (!Auth::user()->isAuthor)
                                <button type="button" class="list-group-item border-end-0 d-inline-block text-truncate"
                                    data-bs-toggle="modal" data-bs-target="#authorRegistrationModal">
                                    <i class="bi bi-envelope"></i> <span>Registrarse como Autor</span>
                                </button>
                                {{-- Modal: --}}
                                <div class="modal fade" id="authorRegistrationModal" tabindex="-1"
                                    aria-labelledby="authorRegistrationModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="authorRegistrationModalLabel">Registrarse como
                                                    Autor</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body w-100">
                                                @include('layouts/user/asAuthor/register')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <a href="{{-- {{ route('publications.index') }} --}}"
                                class="list-group-item border-end-0 d-inline-block text-truncate">
                                <i class="bi bi-bootstrap"></i> <span>Mis publicaciones</span>
                            </a>
                            @endif
                            <div class="mt-5 w-100">
                                <a href="{{ route('logout') }}"
                                    class="w-16 btn btn-primary ms-3 me-3 list-group-item border-end-0 text-truncate mt-auto rounded mb-2">
                                    <i class="bi bi-box-arrow-right"></i> <span>Cerrar Sesión</span>
                                </a>

                                @if (Auth::check())
                                    <button type="button"
                                        class="w-16 btn btn-danger ms-3 me-3 list-group-item border-end-0 text-truncate rounded"
                                        data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
                                        Borrar Cuenta
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-2 h-100">
                    <div class="d-flex align-items-center mt-2">
                        <a href="#" data-bs-target="#sidebar" data-bs-toggle="collapse"
                            class="rounded-3 p-1 text-decoration-none ms-2">
                            <svg width="3vw" height="6vh" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg" transform="rotate(0)">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"
                                    stroke="#ffffff" stroke-width="0.24000000000000005"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M9 12C9 12.5523 8.55228 13 8 13C7.44772 13 7 12.5523 7 12C7 11.4477 7.44772 11 8 11C8.55228 11 9 11.4477 9 12Z"
                                        fill="#ffffff"></path>
                                    <path
                                        d="M13 12C13 12.5523 12.5523 13 12 13C11.4477 13 11 12.5523 11 12C11 11.4477 11.4477 11 12 11C12.5523 11 13 11.4477 13 12Z"
                                        fill="#ffffff"></path>
                                    <path
                                        d="M17 12C17 12.5523 16.5523 13 16 13C15.4477 13 15 12.5523 15 12C15 11.4477 15.4477 11 16 11C16.5523 11 17 11.4477 17 12Z"
                                        fill="#ffffff"></path>
                                    <path
                                        d="M22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C21.5093 4.43821 21.8356 5.80655 21.9449 8"
                                        stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"></path>
                                </g>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-6  mt-5 mb-5 ">

                <section class="card mb-5  mx-auto" style="width: 42vw">
                    <div class="card-header row m-0 align-items-center justify-content-between">
                        <div class="col-auto ms-1">
                            @if (Auth::user()->profile_img)
                                <img src="{{ asset('assets/images/profile/' . Auth::user()->profile_img) }}"
                                    alt="{{ Auth::user()->name }} Profile" class="img-fluid rounded-circle"
                                    style="width: 4vw; height: 4vw; min-width:50px; min-height:50px;">
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="3vw" height="auto" fill="currentColor"
                                    class="bi bi-person-circle" viewBox="0 0 16 16">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                    <path fill-rule="evenodd"
                                        d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                                </svg>
                            @endif
                        </div>
                        <div class="col-6 text-left pe-4">
                            <h3 id="user_nick" class="pe-4">
                                {{ Auth::user()->nickname }}
                            </h3>
                        </div>
                        <div class="col-2 ps-3">
                            @if (Auth::user()->strikes > 0)
                                <div class="card text-start">
                                    <div class="card-header d-flex align-items-center justify-content-center">
                                        <img src="/assets/images/icons/yellow-card.png" alt="strikes"
                                            style="height: auto; max-width: 3vw;">
                                    </div>
                                    <div class="card-body rounded-bottom d-flex align-items-center justify-content-center">
                                        <h5 class="card-text">{{ Auth::user()->strikes }} </h5>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>


                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-3 fw-bold">Nombre:</div>
                            <div class="col">{{ Auth::user()->surnames }}, {{ Auth::user()->name }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-3 fw-bold">Correo Electrónico:</div>
                            <div class="col">{{ Auth::user()->email }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-3 fw-bold">Fecha de Nacimiento:</div>
                            <div class="col">
                                {{ Auth::user()->birth_date ? Auth::user()->birth_date->format('Y-m-d') : '...' }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-3 fw-bold">País:</div>
                            <div class="col">
                                {{ Auth::user()->country_id ? Auth::user()->country->country_name : '...' }}</div>
                        </div>

                        <div class="mb-2" style="position: relative;">
                            <div class="fw-bold">Biografía:</div>
                            <form action="{{ route('profile.update.biography') }}" method="POST" class="w-100">
                                @csrf
                                @method('PATCH')
                                <div style="position: relative;">
                                    <textarea name="biography" id="biography" class="w-100 rounded" cols="30" rows="10"
                                        style="max-height: 15vh; resize: none;">{{ Auth::user()->biography ?? '' }}</textarea>
                                    <button type="submit" class="btn btn-primary"
                                        style="position: absolute; top: 0; right: 0; margin: 5px;"><i
                                            class="bi bi-save"></i></button>
                                </div>
                            </form>
                        </div>



                    </div>

                    <div class="card-footer row justify-content-end m-0 p-3">
                        @if (Auth::check())
                            <a href="{{ route('profile.edit') }}" class="btn btn-secondary col-4">Editar perfil</a>
                        @endif

                    </div>

                    <!-- Modal de Confirmación de Borrado -->
                    <div class="modal fade mt-5" id="confirmDeleteModal" tabindex="-1"
                        aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Borrado de Cuenta</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="deleteAccountForm" action="{{ route('profile.deleteAccount') }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT') <!-- Cambiado de DELETE a PUT -->

                                        <div class="mb-3">
                                            <label for="password" class="form-label">Contraseña:</label>
                                            <input type="password" class="form-control" id="password" name="password"
                                                required>
                                        </div>
                                        <button type="submit" class="btn btn-danger">Confirmar Borrado</button>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>


                </section>

                <section class="row ">
                    <div class="col-6">
                        <div id="booksCarousel" class="carousel slide mt-4 text-center " data-bs-ride="carousel">
                            <h2 class="mb-4">Lista de deseos</h2>
                            <div class="carousel-inner border border-1 border-black rounded p-4 "
                                style="min-height: 500;max-height: 500px;">

                                @if (!empty($wishlistBooks))
                                    @foreach ($wishlistBooks as $index => $wish)
                                        @php
                                            $book = $wish->book; // Accede a la relación "book" desde el deseo
                                        @endphp
                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                            <div class="card mx-auto" style="max-width: 20vw">
                                                <div class="card-header">
                                                    {{ $book->title }}
                                                </div>
                                                <div class="card-body">
                                                    <img src="{{ asset('storage/' . $book->cover) }}"
                                                        alt=" {{ $book->title }}" class="rounded"
                                                        style="max-height: 25vh">
                                                </div>
                                                <div class="card-footer">
                                                    <a href="{{ route('books.show', $book->id) }}"
                                                        class="btn btn-primary">Ver
                                                        Detalle</a>
                                                    @auth
                                                        @php
                                                            $user = Auth::user();
                                                            $isInWishlist = $user->wishes->contains('book_id', $book->id);
                                                        @endphp

                                                        @if (!$isInWishlist)
                                                            <form action="{{ route('wishes.add', ['id' => $book->id]) }}"
                                                                method="POST" class="d-inline">
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
                                                    @endauth
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <p>No hay libros en tu lista de deseos.</p>
                                @endif
                            </div>
                            <button class="carousel-control-prev  mt-5" type="button" data-bs-target="#booksCarousel"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon  mt-3" aria-hidden="true"></span>
                                <span class="visually-hidden">Anterior</span>
                            </button>
                            <button class="carousel-control-next  mt-5" type="button" data-bs-target="#booksCarousel"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon  mt-3" aria-hidden="true"></span>
                                <span class="visually-hidden">Siguiente</span>
                            </button>
                        </div>
                    </div>
                    <div class="col-6 text-center">
                        <div id="booksCarousel" class="carousel slide mt-4 text-center " data-bs-ride="carousel">
                            <h2 class="mb-4">Lista de favoritos</h2>
                            <div class="carousel-inner border border-1 border-black rounded p-4 "
                                style="min-height: 500;max-height: 500px;">
                                @if (empty($favoritesBooks))
                                    @foreach ($favoritesBooks as $index => $book)
                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                            <div class="card mx-auto" style="max-width: 20vw">
                                                <div class="card-header">
                                                    {{ $book->title }}
                                                </div>
                                                <div class="card-body">
                                                    <img src="{{ asset('storage/' . $book->cover) }}"
                                                        alt="Imagen del Género" class="rounded" style="max-height: 25vh">
                                                </div>
                                                <div class="card-footer">
                                                    <a href="{{ route('books.show', $book->id) }}"
                                                        class="btn btn-primary">Ver
                                                        Detalle</a>
                                                    @auth
                                                        @php
                                                            $user = Auth::user();
                                                            $isInWishlist = $user->wishes->contains('book_id', $book->id);
                                                        @endphp

                                                        @if (!$isInWishlist)
                                                            <form action="{{ route('wishes.add', ['id' => $book->id]) }}"
                                                                method="POST" class="d-inline">
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
                                                    @endauth
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <p>No hay libros en tu lista de favoritos.</p>
                                @endif
                            </div>
                            <button class="carousel-control-prev mt-5" type="button" data-bs-target="#booksCarousel"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon mt-3" aria-hidden="true"></span>
                                <span class="visually-hidden">Anterior</span>
                            </button>
                            <button class="carousel-control-next  mt-5" type="button" data-bs-target="#booksCarousel"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon  mt-3" aria-hidden="true"></span>
                                <span class="visually-hidden">Siguiente</span>
                            </button>
                        </div>
                    </div>
                </section>

            </div>

        </div>

    </div>



@endsection
