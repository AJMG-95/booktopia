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
    <style>
        /* Public/css/styles.css */



        #sidebar {
            border-right: 1px solid #dee2e6;
            background: #dee2e6;
            height: 100%;
        }

        #user_nick {
            font-size: 35px;
        }

        .card {
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 50vw;
            margin: auto
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
        }

        .card-header img {
            width: 150px;
            height: 150px;
        }

        .card-body,
        .card-footer {
            background-color: #fff;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 30px;
            color: #007bff;
        }

        .carousel-control-prev:hover,
        .carousel-control-next:hover {
            color: #0056b3;
        }
    </style>

    @section('content')
        <div class="container-fluid">
            <div class="row mt-4">
                <div class="col-auto">
                    <div class="mb-3">
                        <a href="#" data-bs-target="#sidebar" data-bs-toggle="collapse"
                            class="border rounded-3 p-1 text-decoration-none ms-2"><i class="bi bi-list bi-lg py-2 p-1"></i>
                            Menu</a>
                    </div>
                    <div id="sidebar" class="collapse collapse-horizontal show border-end">
                        <div id="sidebar-nav" class="list-group border-0 rounded-0 text-sm-start min-vh-99">
                            <a href="#" class="list-group-item border-end-0 d-inline-block text-truncate"
                                data-bs-parent="#sidebar"><i class="bi bi-bootstrap"></i> <span>Mis publicaciones</span>
                            </a>
                            <a href="#" class="list-group-item border-end-0 d-inline-block text-truncate"
                                data-bs-parent="#sidebar"><i class="bi bi-film"></i> <span>Mi lista de deseos</span></a>
                            <a href="#" class="list-group-item border-end-0 d-inline-block text-truncate"
                                data-bs-parent="#sidebar"><i class="bi bi-heart"></i> <span>Mi lista de
                                    favoritos</span></a>
                            <a href="#" class="list-group-item border-end-0 d-inline-block text-truncate"
                                data-bs-parent="#sidebar"><i class="bi bi-bricks"></i> <span>Mis comentarios</span></a>
                            <a href="#" class="list-group-item border-end-0 d-inline-block text-truncate"
                                data-bs-parent="#sidebar"><i class="bi bi-clock"></i> <span>Mis post</span></a>
                            <a href="#" class="list-group-item border-end-0 d-inline-block text-truncate"
                                data-bs-parent="#sidebar"><i class="bi bi-envelope"></i> <span>Mis
                                    Notificaciones</span></a>
                        </div>
                    </div>
                </div>
                <div class="col-9">
                    <div>
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-5">
                                        <img src="{{ asset('assets/images/profile/' . Auth::user()->profile_img) }}"
                                            alt="{{ Auth::user()->name }} Profile" class="img-fluid rounded-circle">
                                    </div>
                                    <div class="col-5">
                                        <p id="user_nick">
                                            {{ Auth::user()->nickname }}
                                        </p>
                                        <hr>
                                        <h5>{{ Auth::user()->name }} {{ Auth::user()->surnames }}</h5>
                                    </div>
                                    <div class="col-2">
                                        <p>
                                            Strikes
                                        </p>
                                        <hr>
                                        <p>{{ Auth::user()->strikes }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="card-text">Correo Electrónico: {{ Auth::user()->email }}</p>
                                <p class="card-text">Fecha de Nacimiento: {{ Auth::user()->birth_date }}</p>
                                <p class="card-text">País:
                                    {{ Auth::user()->country ? Auth::user()->country->name : 'N/A' }}</p>
                                <p class="card-text">Rol:
                                    {{ Auth::user()->role ? Auth::user()->role->rol_name : 'N/A' }}</p>
                                <p class="card-text">Biografía:
                                    {{ Auth::user()->biography ? Auth::user()->biography : 'N/A' }}
                                </p>
                                <!-- Add more user details as needed -->
                            </div>
                            <div class="card-footer">
                                @if (Auth::check())
                                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">Editar perfil</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="m-auto p-4">
                        <h2 class="mt-4">Lista de Deseos</h2>
                        <div id="carouselWishlist" class="carousel slide mt-4 text-center row" data-bs-ride="carousel">
                            <div class="carousel-inner col-8 ">
                                @forelse ($wishlistBooks as $wishlistBook)
                                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                        <div class="card" style="width: 22vw;">
                                            <div class="card-header">
                                                <img src="{{ $wishlistBook->edition->book_image_url }}"
                                                    class="card-img-top" alt="Book Image">
                                            </div>
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $wishlistBook->edition->title }}</h5>
                                                <p class="card-text">{{ $wishlistBook->edition->description }}</p>
                                                <!-- Add more details or customize as needed -->
                                            </div>
                                            <div class="card-footer">
                                                <form action="{{ route('edition.show', ['id' => $wishlistBook->edition->id]) }}" method="GET"
                                                    class="col">
                                                    @csrf
                                                    <button type="submit" class="btn ">
                                                        <svg version="1.1" id="Uploaded to svgrepo.com"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="2.5vw" height="auto"
                                                            viewBox="0 0 32.00 32.00" xml:space="preserve" fill="#000000"
                                                            transform="rotate(0)">
                                                            <g id="SVGRepo_bgCarrier" stroke-width="0"
                                                                transform="translate(0,0), scale(1)">
                                                                <path transform="translate(0, 0), scale(1)"
                                                                    d="M16,27.234812140464783C18.397045338808,27.10568122996473,20.63279318964606,29.967955500795668,22.856936050878858,29.06480009823479C25.014431574966792,28.18870811127453,24.910215850518682,24.979639685964642,26.2477570669976,23.07351597531637C27.598073710486766,21.149186063589678,30.678784216719723,20.142167200761683,30.76646115008493,17.792972998017778C30.856472480832515,15.381231525574641,28.099675682375235,13.89515851644649,26.662679773565337,11.956178958114645C25.5788153836647,10.493689828440182,24.531460296542974,9.096845942844817,23.316843313112507,7.740991211071199C21.963342481312655,6.230102978574808,20.983757284333596,4.201090470651818,19.082353679653,3.4943995305042925C17.156003652702978,2.7784368026292707,14.959744452787366,3.2322437248764477,13.021171882971831,3.9144192489136174C11.165258016966627,4.56750752315368,10.0162846683357,6.35574697543726,8.286605771501854,7.293377758756524C5.971226028686591,8.548507439711392,2.6170042807650615,8.18685200729833,1.129866670175188,10.360502300381878C-0.29301223168554347,12.440229905969904,0.04588471739579769,15.517446787369451,1.0913257306613993,17.810240796997768C2.1075425635473,20.03894221329882,5.329573188442481,20.390998276647423,6.6454689496033055,22.456966572682465C8.037602819374614,24.642629391633207,6.43626681757506,28.646373430184028,8.744041441897256,29.82507396587691C11.06486033335825,31.0104368872734,13.397763687720918,27.374996866594323,16,27.234812140464783"
                                                                    fill="#7ad973" strokewidth="0"></path>
                                                            </g>
                                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                                stroke-linejoin="round"></g>
                                                            <g id="SVGRepo_iconCarrier">
                                                                <style type="text/css">
                                                                    .feather_een {
                                                                        fill: #000000;
                                                                    }
                                                                </style>
                                                                <path class="feather_een"
                                                                    d="M21.461,6.858L21.461,6.858c0,0-0.001,0-0.001,0C19.858,6.326,18.048,6,16,6 c-2.048,0-3.858,0.326-5.46,0.857c0,0,0,0,0,0l0,0C4.484,8.867,1.471,13.89,0.432,16.02c-0.3,0.616-0.276,1.334,0.081,1.918 C1.923,20.244,6.403,26,16,26s14.077-5.756,15.487-8.062c0.357-0.585,0.382-1.302,0.081-1.918 C30.529,13.89,27.516,8.867,21.461,6.858z M11.012,7.758C12.482,7.284,14.14,7,16,7c1.811,0,3.547,0.281,4.984,0.754 C22.903,9.285,24,11.552,24,14c0,4.411-3.589,8-8,8s-8-3.589-8-8C8,11.554,9.096,9.289,11.012,7.758z M16,25 c-9.181,0-13.359-5.452-14.64-7.58c-0.172-0.286-0.187-0.635-0.04-0.935c0.832-1.701,3.096-5.525,7.415-7.763 c-1.117,1.529-1.775,3.413-1.733,5.462c0.097,4.734,4.025,8.69,8.759,8.812C20.841,23.128,25,19.05,25,14 c0-1.998-0.665-3.832-1.769-5.324c4.386,2.227,6.636,6.086,7.459,7.808c0.143,0.298,0.127,0.642-0.044,0.926 C29.37,19.534,25.194,25,16,25z M11.159,12.809C11.064,13.192,11,13.587,11,14c0,2.761,2.239,5,5,5s5-2.239,5-5s-2.239-5-5-5 c-0.916,0-1.763,0.259-2.497,0.693C13.136,9.272,12.602,9,12,9c-1.105,0-2,0.895-2,2C10,11.803,10.476,12.491,11.159,12.809z M14,11 c0-0.144-0.017-0.284-0.046-0.419C14.555,10.22,15.25,10,16,10c2.206,0,4,1.794,4,4s-1.794,4-4,4s-4-1.794-4-4 c0-0.352,0.051-0.691,0.14-1.014C13.178,12.913,14,12.056,14,11z M12,10c0.552,0,1,0.448,1,1c0,0.552-0.448,1-1,1s-1-0.448-1-1 C11,10.448,11.448,10,12,10z">
                                                                </path>
                                                            </g>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p>No hay libros en tu lista de deseos.</p>
                                @endforelse
                            </div>


                            <button class="carousel-control-prev col-2" type="button" data-bs-target="#carouselWishlist"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>

                            <div class="col-2">
                                <button class="carousel-control-next " type="button" data-bs-target="#carouselWishlist"
                                    data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

</body>

</html>
