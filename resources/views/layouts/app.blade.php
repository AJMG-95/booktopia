{{-- resources/views/layouts/app.blade.php --}}
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Booktopia') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Agrega este enlace en la sección head de tu HTML -->


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/css/components/bookDetail.css', 'resources/js/app.js'])
</head>

<body class="container-fluid appBody">
    <header class="appHeader">
        @include('partials.navigation')
    </header>

    <div class="container-fluid appMain" id="app">
        <div class="container-fluid web-messages">
            @if (isset($errors) && $errors->any())
                <div class="alert alert-danger mt-2 alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (is_array(session()->get('success')))
        <div class="alert alert-success mt-2 alert-dismissible fade show">
            <ul>
                @foreach (session()->get('success') as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif (session()->get('success'))
        <div class="alert alert-success mt-2 alert-dismissible fade show">
            <ul>
                <li>{{ session()->get('success') }}</li>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
        </div>
        @yield('content')
    </div>

    <footer class="appFooter ">
        @include('partials.footer')
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>

</body>

</html>
