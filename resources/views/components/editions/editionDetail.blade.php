{{-- resources/views/components/editions/editionDetail.blade.php --}}

@extends('layouts.app') {{-- Ajusta según la estructura de tu layout --}}

@section('content')
    <div class="container-fluid mt-4 ms-4 p-4 book-detail">
        <div class="book-detail mt-4 ms-4">
            <h1>{{ $edition->title }}</h1>
        </div>
        <div class="edition-detail row">
            <div class="book-detail col-md-4 m-auto p-auto">
                <img src="{{ asset('assets/images/bookCovers/' . $edition->cover) }}" alt="Portada del libro">
            </div>
            <div class="book-detail col-md-8 row">
                <div class="book-detail col-md-6">
                    <dl class="book-detail mt-1">
                        <dt>
                            <h4>Géneros</h4>
                        </dt>
                        <dd class="book-detail ms-4">
                            @forelse ($edition->book->genres as $genre)
                                <p>{{ $genre->genre }}</p>
                            @empty
                                <p><em>Este libro no tiene géneros asignados.</em></p>
                            @endforelse
                        </dd>

                        <dt>
                            <h4>Autores</h4>
                        </dt>
                        <dd class="book-detail ms-4">
                            @forelse ($edition->book->authors as $author)
                                <p>{{ $author->name }}</p>
                            @empty
                                <p><em>Este libro no tiene autores asignados.</em></p>
                            @endforelse
                        </dd>
                        <dt>Valoración media</dt>
                        <dd class="book-detail ms-4">
                            @if ($edition->averageRating() > 0)
                                {{ number_format($edition->averageRating(), 2) }}
                            @else
                                Esta edición aún no ha sido valorada
                            @endif
                        </dd>
                    </dl>
                </div>
                <div class="book-detail col-md-6 p-4 text-center">
                    <p class="book-detail pe-4 text-center">
                        {!! $edition->description !!}
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <p>Precio: {{ $edition->price }} €</p>
                </div>
                <div class="col-9">
                    @if (!$userHasPurchased)
                        <form action="{{ route('stripe') }}" method="POST">
                            @csrf
                            <input type="hidden" name="price" value="{{ $edition->price }}">
                            <input type="hidden" name="title" value="{{ $edition->title }}">
                            <input type="hidden" name="quantity" value="1">
                            <input type="hidden" name="edition_id" value="{{ $edition->id }}">

                            <!-- Include customer details if available -->
                            @if(auth()->check())
                                <input type="hidden" name="customer_name" value="{{ auth()->user()->name }}">
                            @endif

                            <button type="submit">Comprar</button>
                        </form>
                    @else
                        <p>Ya has comprado esta edición.</p>
                    @endif
                </div>


            </div>
        </div>

        <div class="container-fluid">
            <section class="comments-section">
                <h1>Comentarios</h1>
                <div class="comments-detail row">
                    <div class="col-md-12">
                        <ul>
                            @forelse ($edition->comments as $comment)
                                <li>
                                    <strong>{{ $comment->user->nickname ?? 'Usuario eliminado' }}:</strong>
                                    {{ $comment->body }}
                                </li>
                            @empty
                                <p>No hay comentarios para esta edición.</p>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
