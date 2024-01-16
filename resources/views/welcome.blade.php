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
        <div class="row justify-content-center mt-4 mb-3 me-0">
            <div class="col-4">
                @include('partials.randomBook')
            </div>
            <div class="col-4">
                @include('partials.randomGenres')
            </div>
        </div>

        <div class="mt-4 mb-5">
            @include('partials.cotact_us')
        </div>
    @endsection
</body>

</html>
