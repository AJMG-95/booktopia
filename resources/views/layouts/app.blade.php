<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite([
        'resources/css/app.css',
        'resources/css/navigation.css',
        'resources/css/footer.css',
        'resources/js/app.js'
        ])
</head>

<body class="container-fluid appBody">
    <header class="appHeader">
        @include('partials.navigation')
    </header>

    <div class="container-fluid appMain" id="app">
        @yield('content')
    </div>

    <footer class="appFooter">
        @include('partials.footer')
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
