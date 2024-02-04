@extends('layouts.app')


@section('content')
    <div class="container-fluid ms-0 me-0 px-3  mt-2">
        <div class="row">
            <div class="col-auto me-2 row aside">
                <div class="col-auto  ">
                    <div id="sidebar" class="collapse collapse-horizontal show border-end pb-5 bg-white">
                        <div id="sidebar-nav" class="list-group border-0 rounded-0 text-sm-start d-flex flex-column">
                            @if (!Auth::user()->isAdmin() && !Auth::user()->isSubadmin())
                                <a href="{{ route('wishes.list') }}"
                                    class="list-group-item border-end-0 d-inline-block text-truncate mt-2">
                                    <i class="bi bi-bookmark"></i> <span>Mi lista de deseos</span>
                                </a>
                                <a href="{{ route('favorite.list') }}"
                                    class="list-group-item border-end-0 d-inline-block text-truncate">
                                    <i class="bi bi-heart"></i> <span>Mi lista de favoritos</span>
                                </a>
                                <a href="{{ route('user.comments.posts') }}"
                                    class="list-group-item border-end-0 d-inline-block text-truncate">
                                    <i class="bi bi-signpost"></i> <span>Mis posts y comentarios</span>
                                </a>

                                @if (!Auth::user()->isAuthor)
                                    <button type="button" class="list-group-item border-end-0 d-inline-block text-truncate"
                                        data-bs-toggle="modal" data-bs-target="#authorRegistrationModal">
                                        <i class="bi bi-feather"></i></i> <span>Registrarse como Autor</span>
                                    </button>
                                @endif

                                {{-- Modal para registrarse como autor --}}
                                <div class="modal fade" id="authorRegistrationModal" tabindex="-1"
                                    aria-labelledby="authorRegistrationModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="authorRegistrationModalLabel">
                                                    Registrarse como Autor <i class="bi bi-feather"></i>
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
                                            class="mt-2 btn btn-danger list-group-item text-truncate rounded w-100"
                                            data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
                                            Borrar Cuenta
                                        </button>
                                    @endif

                                </div>
                            @else
                                <a href="{{ route('contact_us.admin_index') }}"
                                    class="list-group-item border-end-0 d-inline-block text-truncate mt-2">
                                    <i class="bi bi-envelope"></i> <span>Notificaciones</span>
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
            </div>
            <div class="col-2 h-100">
                <div class="d-flex align-items-center mt-2">
                    <button class="btn rounded-3 p-1 text-decoration-none ms-2" data-bs-target="#sidebar"
                        data-bs-toggle="collapse">
                        <svg width="3vw" height="6vh" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg" transform="rotate(0)" style="min-width: 50px">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#ffffff"
                                stroke-width="0.24000000000000005"></g>
                            <g id="SVGRepo_iconCarrier">
                                <circle cx="8" cy="12" r="1" fill="#ffffff"></circle>
                                <circle cx="12" cy="12" r="1" fill="#ffffff"></circle>
                                <circle cx="16" cy="12" r="1" fill="#ffffff"></circle>
                                <path
                                    d="M21 12C21 16.714 21 19.0711 19.5355 20.5355C18.0711 22 15.714 22 11 22C6.28595 22 3.92893 22 2.46447 20.5355C1 19.0711 1 16.714 1 12C1 7.28595 1 4.92893 2.46447 3.46447C3.92893 2 6.28595 2 11 2C15.714 2 18.0711 2 19.5355 3.46447C20.5093 4.43821 20.8356 5.80655 20.9449 8"
                                    stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"></path>
                            </g>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="col-12 col-md-6 mt-5 mb-5">
                {{-- Mensaje de fin de suscripción --}}
                @if (Auth::user()->isSubscriber())
                    <div x-data="{ daysLeft: {{ now()->diffInDays(Auth::user()->subscriber->end_at) }} }">
                        <div x-show="daysLeft <= 10" class="alert alert-warning mt-4">
                            Solo faltan <span x-text="daysLeft"></span> días para el fin de su suscripción.
                            Recuerde renovarla pasada la fecha {{ Auth::user()->subscriber->end_at }}
                        </div>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table p-0">
                        <th class="p-0">
                            <div class="card-header row m-0 align-items-center justify-content-between">
                                <div class="col-auto ms-1">
                                    @if (Auth::check() && !empty(Auth::user()->profile_img))
                                        <img src="{{ asset('assets/images/profile/' . Auth::user()->profile_img) }}"
                                            alt="{{ Auth::user()->name }} Profile" class="img-fluid rounded-circle my-2"
                                            style="width: 50px; height: 50px; min-width: 50px; min-height: 50px;">
                                    @else
                                        <div class="my-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50"
                                                fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                                                <path fill-rule="evenodd"
                                                    d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                                            </svg>
                                        </div>
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
                                                    style="height: auto; max-width: 50px;">
                                            </div>
                                            <div
                                                class="card-body rounded-bottom d-flex align-items-center justify-content-center">
                                                <h5 class="card-text">{{ Auth::user()->strikes }} </h5>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </th>
                        <tr>
                            <td>
                                <div class="card-body">
                                    <div class="mb-2 row">
                                        <div class="col-12 col-md-3 fw-bold">Nombre:</div>
                                        <div class="col-12 col-md">{{ Auth::user()->surnames }}, {{ Auth::user()->name }}
                                        </div>
                                    </div>

                                    <div class="mb-2 row">
                                        <div class="col-12 col-md-3 fw-bold">Correo Electrónico:</div>
                                        <div class="col-12 col-md">{{ Auth::user()->email }}</div>
                                    </div>

                                    <div class="mb-2 row">
                                        <div class="col-12 col-md-3 fw-bold">Fecha de Nacimiento:</div>
                                        <div class="col-12 col-md">
                                            {{ Auth::user()->birth_date ? Auth::user()->birth_date->format('Y-m-d') : '...' }}
                                        </div>
                                    </div>

                                    <div class="mb-2 row">
                                        <div class="col-12 col-md-3 fw-bold">País:</div>
                                        <div class="col-12 col-md">
                                            {{ Auth::user()->country_id ? Auth::user()->country->country_name : '...' }}
                                        </div>
                                    </div>

                                    <div class="mb-2">
                                        <div class="fw-bold">Biografía:</div>
                                        <form action="{{ route('profile.update.biography') }}" method="POST"
                                            class="w-100">
                                            @csrf
                                            @method('PATCH')
                                            <div class="position-relative">
                                                <textarea name="biography" id="biography" class="w-100 rounded" cols="30" rows="10"
                                                    style="max-height: 15vh; resize: none;">{{ Auth::user()->biography ?? '' }}</textarea>
                                                <button type="submit"
                                                    class="btn btn-primary position-absolute top-0 end-0 m-2"
                                                    data-bs-toggle="tooltip" data-bs-placement="left" title="Guardar">
                                                    <i class="bi bi-save"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="card-footer row justify-content-end m-0 p-3">
                                    @if (Auth::check())
                                        <div class="col-12 col-sm-4 mb-2 mb-sm-0">
                                            <a href="{{ route('profile.edit') }}" class="btn btn-secondary w-100">Editar
                                                perfil</a>
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>



                @if (isset($author))
                    <div class="table-responsive mt-4">
                        <table class="table p-0">
                            <th class="p-0">
                                <div class="card-header row m-0 align-items-center justify-content-between">
                                    <div class="col-auto ms-1">
                                        @if ($author->photo)
                                            <img src="{{ asset('storage/' . $author->photo) }}"
                                                alt="{{ $author->nickname }} Profile" class="img-fluid rounded-circle"
                                                style="width: 4vw; height: 4vw; min-width:50px; min-height:50px; max-width: 50px; max-height: 50px;">
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
                                    <div class="col-2 ps-3"></div>
                                </div>
                            </th>
                            <tr>
                                <td>
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-3 fw-bold">Nombre:</div>
                                            <div class="col">{{ $author->surnames }}, {{ $author->name }}</div>
                                        </div>

                                        <div class="row mb-2">
                                            <div class="col-3 fw-bold">Fecha de Nacimiento:</div>
                                            <div class="col">{{ $author->birth_at ? $author->birth_at : '...' }}</div>
                                        </div>

                                        <div class="row mb-2">
                                            <div class="col-3 fw-bold">País:</div>
                                            <div class="col">
                                                {{ $author->country_id ? $author->country->country_name : '...' }}
                                            </div>
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
                                                        data-bs-toggle="tooltip" data-bs-placement="left"
                                                        title="Guardar">
                                                        <i class="bi bi-save"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="card-footer row justify-content-around m-0 p-3">
                                        <a href="{{ route('profile.publication.list') }}"
                                            class="btn btn-secondary col-12 col-md-4 mb-2 mb-md-0">Ver mis
                                            publicaciones</a>

                                        <button type="button" class="btn btn-secondary col-12 col-md-4"
                                            data-bs-toggle="modal" data-bs-target="#uploadModal">
                                            Publicar
                                        </button>
                                        @include('partials/dropzone_books')
                                    </div>
                                </td>
                            </tr>
                        </table>

                    </div>
                @endif

            </div>
        </div>
    </div>

    <!-- Agrega esto al encabezado de tu vista -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/alpine.min.js" defer></script>

@endsection
