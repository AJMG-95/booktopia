{{-- resources/views/components/book/bookDetail.blade.php --}}

@extends('layouts.app') {{-- Ajusta según la estructura de tu layout --}}

@section('content')
    <div class="container-fluid mt-4 ms-4 p-4 book-detail">
        <div class="book-detail mt-4 ms-4">
            <h1>{{ $book->original_title }}</h1>
        </div>
        <div class="book-detail row">
            <div class="book-detail col-md-4 m-auto p-auto">
                <img src="{{ asset('assets/images/bookCovers/' . $book->cover) }}" alt="Portada del libro">
            </div>
            <div class="book-detail col-md-8 row">
                <div class="book-detail col-md-6">
                    <dl class="book-detail mt-1">
                        <dt>
                            <h4>Géneros</h4>
                        </dt>
                        <dd class="book-detail ms-4">
                            @forelse ($book->genres as $genre)
                                <p>{{ $genre->genre }}</p>
                            @empty
                                <p><em>Este libro no tiene géneros asignados.</em></p>
                            @endforelse
                        </dd>

                        <dt>
                            <h4>Autores</h4>
                        </dt>
                        <dd class="book-detail ms-4">
                            @forelse ($book->authors as $author)
                                <p>{{ $author->name }}</p>
                            @empty
                                <p><em>Este libro no tiene autores asignados.</em></p>
                            @endforelse
                        </dd>

                        <dt>Autopublicado</dt>
                        <dd class="book-detail ms-4">{{ $book->self_published ? 'Sí' : 'No' }}</dd>
                        <dt>Número de ediciones
                            <a href="{{ route('editions.forBook', ['book' => $book->id]) }}">
                                <div class="related-editions">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="212529" class="bi bi-search" viewBox="0 0 16 16">
                                        <path
                                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                                    </svg>

                                    <svg xmlns="http://www.w3.org/2000/svg" width="7" height="7"
                                        fill="212529" class="bi bi-book book-icon " viewBox="0 0 16 16">
                                        <path
                                            d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783" />
                                    </svg>
                                </div>
                            </a>
                        </dt>
                        <dd class="book-detail ms-4">{{ $book->editions->count() }}</dd>
                        <dt>Valoración media</dt>
                        <dd class="book-detail ms-4">
                            @if ($book->editions->count() > 0 && $book->averageRating() > 0)
                                {{ number_format($book->averageRating(), 2) }}
                            @else
                                Este libro aún no ha sido valorado
                            @endif
                        </dd>
                    </dl>
                </div>
                <div class="book-detail col-md-6 p-4 text-center">
                    <p class="book-detail pe-4 text-center">
                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Vero voluptate exercitationem at aliquid
                        eum dolorem nihil asperiores veritatis corrupti. Dolore quia veritatis itaque temporibus sed
                        placeat? Pariatur eum possimus magnam.
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi, illo nisi non eligendi iste quia
                        eius hic blanditiis sunt laudantium, soluta velit fuga maiores ipsa ullam necessitatibus, minus
                        magnam minima.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
