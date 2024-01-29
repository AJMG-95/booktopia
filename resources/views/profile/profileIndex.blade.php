@extends('layouts.app')


@section('content')
    <div class="container-fluid ms-0 me-0 px-3  mt-2">
        <div class="row">
            <div class="col-3 me-2 row aside">
                <div class="col-auto  ">
                    <div id="sidebar" class="collapse collapse-horizontal show border-end pb-5 bg-white">
                        <div id="sidebar-nav" class="list-group border-0 rounded-0 text-sm-start d-flex flex-column">
                            @if (!(Auth::user()->isAdmin() || Auth::user()->isSubadmin()))
                                <a href=" {{ route('wishes.list') }}"
                                    class="list-group-item border-end-0 d-inline-block text-truncate mt-2">
                                    <i class="bi bi-bookmark"></i> <span>Mi lista de deseos</span>
                                </a>
                                <a href="{{ route('favorite.list') }}"
                                    class="list-group-item border-end-0 d-inline-block text-truncate">
                                    <i class="bi bi-heart"></i> <span>Mi lista de favoritos</span>
                                </a>
                                <a href=" {{ route('user.comments.posts') }}"
                                    class="list-group-item border-end-0
                                    d-inline-block text-truncate">
                                    <i class="bi bi-signpost"></i> <span>Mis posts y comentarios</span>
                                </a>
                                <a href="#" class="list-group-item border-end-0 d-inline-block text-truncate">
                                    <i class="bi bi-mailbox2"></i> <span>Mis Notificaciones</span>
                                </a>
                                {{--  <a href="#" class="list-group-item border-end-0 d-inline-block text-truncate">
                                    <i class="bi bi-mailbox2-flag"></i> <span>Mis Notificaciones para cuando hay</span>
                                </a> --}}

                                @if (!Auth::user()->isAuthor)
                                    <button type="button" class="list-group-item border-end-0 d-inline-block text-truncate"
                                        data-bs-toggle="modal" data-bs-target="#authorRegistrationModal">
                                        <i class="bi bi-feather"></i></i> <span>Registrarse como Autor</span>
                                    </button>
                                @endif
                                {{-- Modal para registrarse como autor --}}
                                <div class="modal fade " id="authorRegistrationModal" tabindex="-1"
                                    aria-labelledby="authorRegistrationModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="authorRegistrationModalLabel">
                                                    Registrarse
                                                    como
                                                    Autor <i class="bi bi-feather"></i>
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body w-100">
                                                @include('layouts/user/asAuthor/register')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-5 mb-5"></div>
                                <div class="mt-5 w-100 px-4 d-flex flex-column align-items-center">
                                    <a class="btn btn-primary list-group-item text-truncate mt-auto rounded mb-2 w-100"
                                        href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>

                                    @if (Auth::check())
                                        <button type="button"
                                            class="w-16 btn btn-danger list-group-item text-truncate rounded w-16"
                                            data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
                                            Borrar Cuenta
                                        </button>
                                    @endif
                                </div>
                            @else
                                <a href="#" class="list-group-item border-end-0 d-inline-block text-truncate mt-2">
                                    <i class="bi bi-envelope"></i> <span>Mis Notificaciones</span>
                                </a>
                                <div class="mt-5 w-100 px-4 d-flex flex-column align-items-center">
                                    <a class="btn btn-primary list-group-item text-truncate mt-auto rounded mb-2 w-100"
                                        href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            @endif
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

                {{-- Mensaje de fin de suscripción --}}
                @if (Auth::user()->isSubscriber())
                    <div x-data="{ daysLeft: {{ now()->diffInDays(Auth::user()->subscriber->end_at) }} }">
                        <div x-show="daysLeft <= 10" class="alert alert-warning mt-4">
                            Solo faltan <span x-text="daysLeft"></span> días para el fin de su suscripción.
                            Recuerde renovarla pasada la fecha {{ Auth::user()->subscriber->end_at }}
                        </div>
                    </div>
                @endif


                <section class="card mb-5  mx-auto" style="width: 42vw">
                    <div class="card-header row m-0 align-items-center justify-content-between">
                        <div class="col-auto ms-1">
                            @if (Auth::user()->profile_img)
                                <img src="{{ asset('assets/images/profile/' . Auth::user()->profile_img) }}"
                                    alt="{{ Auth::user()->name }} Profile" class="img-fluid rounded-circle"
                                    style="width: 4vw; height: 4vw; min-width:50px; min-height:50px;">
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="3vw" height="auto"
                                    fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
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
                                        style="position: absolute; top: 0; right: 0; margin: 5px;"
                                        data-bs-toggle="tooltip" data-bs-placement="left" title="Guardar">
                                        <i class="bi bi-save"></i>
                                    </button>
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

                @if (isset($author))
                    <section class="card mb-5  mx-auto" style="width: 42vw">
                        <div class="card-header row m-0 align-items-center justify-content-between">
                            <div class="col-auto ms-1">
                                @if ($author->photo)
                                    <img src="{{ asset('storage/' . $author->photo) }}"
                                        alt="{{ $author->nickname }} Profile" class="img-fluid rounded-circle"
                                        style="width: 4vw; height: 4vw; min-width:50px; min-height:50px;">
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" width="3vw" height="auto"
                                        fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
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
                            </div>
                        </div>


                        <div class="card-body ">
                            <div class="row mb-2">
                                <div class="col-3 fw-bold">Nombre:</div>
                                <div class="col">{{ $author->surnames }}, {{ $author->name }}</div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-3 fw-bold">Fecha de Nacimiento:</div>
                                <div class="col">
                                    {{ $author->birth_at ? $author->birth_at : '...' }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-3 fw-bold">País:</div>
                                <div class="col">
                                    {{ $author->country_id ? $author->country->country_name : '...' }}</div>
                            </div>

                            <div class="mb-2" style="position: relative;">
                                <div class="fw-bold">Biografía:</div>
                                <form action="{{ route('profile.author.update.biography') }}" method="POST"
                                    class="w-100">
                                    @csrf
                                    @method('PATCH')
                                    <div style="position: relative;">
                                        <textarea name="biography" id="biography" class="w-100 rounded" cols="30" rows="10"
                                            style="max-height: 15vh; resize: none;">{{ $author->biography ?? '' }}</textarea>
                                        <button type="submit" class="btn btn-primary"
                                            style="position: absolute; top: 0; right: 0; margin: 5px;"
                                            data-bs-toggle="tooltip" data-bs-placement="left" title="Guardar">
                                            <i class="bi bi-save"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-footer row justify-content-around m-0 p-3">
                            <a href=" {{ route('profile.publication.list') }} " class="btn btn-secondary col-4">Ver mis
                                publicaciones</a>

                            <button type="button" class="btn btn-secondary col-4" data-bs-toggle="modal"
                                data-bs-target="#uploadModal">
                                Publicar
                            </button>
                            @include('partials/dropzone_books')
                        </div>
                    </section>
                @endif

            </div>
        </div>
    </div>

    <!-- Agrega esto al encabezado de tu vista -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/alpine.min.js" defer></script>

@endsection
