<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Navigation</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm app-navbar">
        <div class="container-fluid ms-5 p-2">
            <a class="navbar-brand" href="{{ route('welcome') }}">
                <img src="{{ asset('assets/images/logos/logo2.png') }}" alt="Logo"
                style="max-height: 6vh">
                {{ config('app.name', 'Booktopia') }}
            </a>
            <button class="navbar-toggler me-5" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                @guest
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item {{ request()->routeIs('welcome') ? 'border border-black rounded bg-blue' : '' }}">
                            <a class="nav-link" href="{{ route('welcome') }}">Inicio</a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('books.shop') ? 'border border-black rounded bg-blue ' : '' }}">
                            <a class="nav-link" href="{{ route('books.shop') }}">Tienda</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 me-5">
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-person" viewBox="0 0 16 16">
                                    <path
                                        d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z" />
                                </svg>
                            </a>
                            <ul class="dropdown-menu " aria-labelledby="navbarDropdown" >
                                <li>
                                    <a class="dropdown-item" href="{{ route('login') }}">Iniciar Sesión</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('register') }}">Registrarse</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                @else
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item {{ request()->routeIs('welcome') ? 'border border-black rounded bg-blue' : '' }}">
                            <a class="nav-link" href="{{ route('welcome') }}">Inicio</a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('books.shop') ? 'border border-black rounded bg-blue ' : '' }}">
                            <a class="nav-link" href="{{ route('books.shop') }}">Tienda</a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('user_posts.index') ? 'border border-black rounded bg-blue   ' : '' }}">
                            <a class="nav-link" href="{{ route('user_posts.index') }}">Foro</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 me-5">
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true">
                                {{ Auth::user()->name }}
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-person" viewBox="0 0 16 16">
                                    <path
                                        d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z" />
                                </svg>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown" style="">
                                <li>
                                    <a class="dropdown-item" href=" {{ route('profile.index') }} ">Perfil</a>
                                </li>
                                @if (Auth::user()->isAdmin() || Auth::user()->isSubadmin())
                                    <li>
                                        <a class="dropdown-item" href="{{ route('home') }}">Home</a>
                                    </li>
                                @else
                                    <li>
                                        <a class="dropdown-item" href="{{ route('user.library') }}">Libreria</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('sticky_note.index') }} ">Notas</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href=" {{ route('wishes.list') }} ">Lista de Deseos</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href=" {{ route('favorite.list') }} ">Lista de Favoritos</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href=" {{ route('user.comments.posts') }} ">Posts & Comentarios</a>
                                    </li>

                                @endif
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                @endguest
            </div>
        </div>
    </nav>
</body>

</html>
