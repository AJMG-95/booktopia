@extends('layouts.app')

@section('content')
    <div class="container-fluid ms-0 me-0 px-3 py-3 mt-2">
        <div class="ms-3 mb-4 text-center p-3" style="background-color:rgba(247, 247, 247, 0.651)">
            <ins>
                <h1 class="display-4 fw-bold" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);">
                    Lista de Deseos
                </h1>
            </ins>
        </div>

        <div class="row justify-content-center">
            @forelse ($wishes as $wish)
                <div class="col-auto mb-4">
                    <div class="card ms-3 border border-black rounded p-0"
                        style="max-width: 15vw; background-color: rgba(247, 247, 247, 0.651)">
                        <div class="card-header text-center">
                            <h5>
                                {{ $wish->book->title }}
                            </h5>
                        </div>
                        <div class="card-body text-center">
                            <div style="width: 150px; height: 150px; margin: auto"
                                class="mt-1 border rounded-1 mb-2 overflow-hidden">
                                <img src="{{ asset('storage/' . $wish->book->cover) }}" class="card-img-top rounded-1"
                                    alt="{{ $wish->book->title }}"
                                    style="object-fit: cover; width: 100%; height: 100%">
                            </div>
                        </div>

                        <div class="card-footer  text-center">
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ route('books.details', $wish->book->id) }}"
                                        class="btn btn-primary btn-block">Ver Detalle</a>
                                </div>
                                <div class="col-6">
                                    <form action="{{ route('wishes.remove', $wish->book_id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-block">
                                            <i class="bi bi-bookmark-fill"></i> Quitar de la lista
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <p class="text-center">No hay libros en tu lista de deseos.</p>
            @endforelse
        </div>
    </div>
@endsection
