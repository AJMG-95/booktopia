<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Booktopia</title>


    <style>
        body {
            padding-top: 56px; /* Adjust for the fixed navbar height */
        }
    </style>
</head>

<body>

    @extends('layouts.app')

    @section('content')
    <div class="container-fluid ms-0 me-0 px-3 py-3 mt-2">
        <div class="ms-3 mb-4 text-center p-2" style="background-color:rgba(247, 247, 247, 0.651)">
            <h1 class="display-4 fw-bold" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);">
                <img src="{{ asset('assets/images/logos/logo2.png') }}" alt="Logo" style="max-height: 10vh" class="img-fluid">
                <ins>
                    BookTopia
                </ins>
            </h1>
        </div>
        <div class="text-center mt-4 mb-3">
            <div class="d-flex justify-content-around flex-wrap">
                <div class="mx-2">
                    @include('partials.topSelling')
                </div>

                <div class="mx-2">
                    @include('partials.leastSelling')
                </div>
            </div>
        </div>
    </div>
    @endsection
</body>

</html>
