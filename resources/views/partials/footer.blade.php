<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/partials/footer.css'])
    <title>Footer</title>
</head>

<body>

</body>
<footer class="container-fluid text-center">
    <div class="row text-center mb-2 align-items-center">
        <div class="col-md-6 text-center">
            <img src="{{ asset('assets/images/logos/logo2.png') }}" alt="Logo"
                style="max-height: 6vh; background-color: white; border-radius: 50%;">
        </div>
        <div class="col-md-6 text-center">
            @guest
                <div class="row text-center">
                    <div class="col-6 text-center">
                        <span class="">Register</span>
                        <a href="{{ route('register') }}" class="btn btn-outline-light btn-rounded">Sign up</a>
                    </div>
                    <div class="col-6 text-center">
                        <span class="">Login</span>
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-rounded">Log in</a>
                    </div>
                </div>
            @else
                @if (!auth()->user()->subscribed)
                    <div class="col-12 text-center">
                        <span class="me-3">Suscribete Ahora <b><a href="{{-- {{ route('subscribe') }} --}}"
                                    class="">Suscribirse</a></b></span>

                    </div>
                @else
                    <div class="col-12 text-center">
                        <span class="me-3">Bien venido de nuevo, <b> {{ auth()->user()->nickname }} </b></span>
                    </div>
                @endif
            @endguest
        </div>
    </div>
    <div class="text-white" style="background: purple; padding: 10px;">
        © {{ date('Y') }} Copyright:
        <a href="#" class="text-white">Booktopia</a>
    </div>
</footer>

</html>
