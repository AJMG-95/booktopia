@extends('layouts.app') <!-- Asegúrate de que estás extendiendo tu layout principal -->

@section('content')
    <div class="container-fluid mt-4 ms-5">
        <div class="row">
            <div class="col-md-8">
                <!-- Información principal del libro -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h2>{{ $book->original_title }}</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="{{ 'assets/images/bookCovers' . '/' . $book->cover }}" alt="Portada del libro" class="img-fluid">
                            </div>
                            <div class="col-md-8">
                                <p><strong>Autores:</strong>
                                    @foreach ($book->authors as $author)
                                        {{ $author->name }}/

                                    @endforeach
                                </p>
                                <p><strong>Géneros:</strong>
                                    @foreach ($book->genres as $genre)
                                        {{ $genre->genre }}/

                                    @endforeach
                                </p>
                                <p><strong>Número de Ediciones:</strong> {{ $book->editions->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lista de Ediciones del Libro -->
                <div class="card">
                    <div class="card-header">
                        <h3>Ediciones</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($book->editions as $edition)
                                <div class="col-md-6 mb-3">
                                    <article class="postcard dark {{ $loop->iteration % 2 == 0 ? 'blue' : 'green' }}">
                                        <!-- Aquí deberías ajustar las propiedades específicas de la edición -->
                                        <div class="postcard__img_link">
                                            <img class="postcard__img" src="{{ $edition->cover_url }}" alt="Portada de la edición" />
                                        </div>
                                        <div class="postcard__text t-dark">
                                            <h1 class="postcard__title {{ $loop->iteration % 2 == 0 ? 'blue' : 'green' }}"><a href="#">{{ $edition->title }}</a></h1>
                                            <!-- Agrega más detalles según tus necesidades -->
                                            <div class="postcard__subtitle small">
                                                <time datetime="{{ $edition->release_date }}">{{ $edition->release_date->format('D, M j, Y') }}</time>
                                            </div>
                                            <div class="postcard__bar"></div>
                                            <div class="postcard__preview-txt">{{ $edition->description }}</div>
                                            <!-- Agrega más detalles según tus necesidades -->
                                            <ul class="postcard__tagbox">
                                                <li class="tag__item"><i class="fas fa-clock mr-2"></i>{{ $edition->duration }} mins.</li>
                                            </ul>
                                        </div>
                                    </article>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
