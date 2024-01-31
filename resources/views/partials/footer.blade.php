<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Footer</title>
    <style>
        .footer-links {
            display: flex;
            justify-content: center;
        }

        .footer-links a {
            margin: 0 10px;
        }
    </style>
</head>

<body>
    <footer class="container text-center">
        <div class="row mb-2 align-items-center">
            <div class="col-6 d-flex align-items-center justify-content-center">
                <div class="">
                    <img src="{{ asset('assets/images/logos/logo2.png') }}" alt="Logo" style="max-width: 100px;">
                    <h4 class="mt-3">Booktopia</h4>
                    <div class="text-black">
                        © {{ date('Y') }} Copyright:
                        <a href="{{ route('welcome') }}" class="text-black">Booktopia</a>
                    </div>
                </div>
                @auth
                    @if (Auth::user()->isSubscriber() && !Auth::user()->isAdmin() && !Auth::user()->isSubadmin())
                        <div class="ms-5 ml-3">
                            <span class="mb-2">Bienvenido de nuevo, <b>{{ auth()->user()->nickname }}</b></span>
                        </div>
                    @endif
                @endauth
            </div>

            <div class="col-6 d-flex align-items-center justify-content-center">
                @guest
                    <div class="footer-links">
                        <div>
                            <span class="text-uppercase mb-2">Registrarse</span>
                            <a href="{{ route('register') }}"
                                class="btn btn-outline-light btn-rounded border-dark text-dark" role="button"
                                aria-label="Registrarse">Registrarse</a>
                        </div>
                        <div>
                            <span class="text-uppercase mb-2">Iniciar sesión</span>
                            <a href="{{ route('login') }}" class="btn btn-outline-light btn-rounded border-dark text-dark"
                                role="button" aria-label="Iniciar sesión">Log in</a>
                        </div>
                        <div>
                            <span class="text-uppercase mb-2">Contacta con nosotros</span>
                            <a href="{{ route('contact_us.form') }}"
                                class="btn btn-outline-light btn-rounded border-dark text-dark" role="button"
                                aria-label="Contacta con nosotros">Contactar</a>
                        </div>
                    </div>
                @else
                    <div class="footer-links ms-5">
                        @if (!Auth::user()->isSubscriber() && !Auth::user()->isAdmin() && !Auth::user()->isSubadmin())
                            <div class="">
                                <span class="text-uppercase mb-2">Suscríbete Ahora</span>
                                <a href="{{ route('subscribe.view') }}"
                                    class="btn btn-outline-light btn-rounded border-dark text-dark" role="button"
                                    aria-label="Contacta con nosotros">Suscribirse</a>
                            </div>
                        @elseif (!Auth::user()->isSubadmin() && !Auth::user()->isAdmin())
                            <div>
                                <span class="text-uppercase mb-2">Contacta con nosotros</span>
                                <a href="{{ route('contact_us.form') }}"
                                    class="btn btn-outline-light btn-rounded border-dark text-dark" role="button"
                                    aria-label="Contacta con nosotros">Contactar</a>
                            </div>
                        @else
                            <div>
                                <span class="text-uppercase mb-2">Contacta con nosotros</span>
                                <a href="{{ route('contact_us.admin_index') }}"
                                    class="btn btn-outline-light btn-rounded border-dark text-dark" role="button"
                                    aria-label="Contacta con nosotros">Notificacniones</a>
                            </div>
                        @endif
                    </div>
                @endguest
            </div>
        </div>
    </footer>

</body>

</html>
