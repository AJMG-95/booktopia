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
    <div class="row">
        <div class="col-md-6">
            <img src="{{ asset('images/logos/your_logo.png') }}" alt="Logo">
        </div>
        <div class="col-md-6 row">
            @guest
                <div class="col-6">
                    <span class="">Register</span>
                    <a href="{{ route('register') }}" class="btn btn-outline-light btn-rounded">Sign up!</a>
                </div>
                <div class="col-6">
                    <span class="">Login</span>
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-rounded">Sign up!</a>
                </div>
            @else
                @if (!auth()->user()->subscribed)
                    <div class="col-12">
                        <span class="me-3">Subscribe now</span>
                        <a href="{{-- {{ route('subscribe') }} --}}" class="btn btn-outline-light btn-rounded">Subscribe</a>
                    </div>
                @else
                    <div class="col-12">
                        <span class="me-3">Subscribe now</span>                    </div>
                @endif
            @endguest
        </div>
    </div>
    <div class="" style="background-color: rgba(0, 0, 0, 0.2);">
        © {{ date('Y') }} Copyright:
        <a class="text-white">Booktopia</a>
    </div>
</footer>

</html>
