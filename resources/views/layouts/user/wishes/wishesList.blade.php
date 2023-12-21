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
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Lista de Deseos</div>

                        <div class="card-body">
                            @if ($wishlist->isEmpty())
                                <p>No hay ediciones en tu lista de deseos.</p>
                            @else
                                <ul>
                                    @foreach ($wishlist as $wish)
                                        <li>{{ $wish->edition->title }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection


</body>

</html>
