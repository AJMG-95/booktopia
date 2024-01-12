@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1>Lista de Deseos</h1>
        @foreach ($wishes as $wish)
            <div>
                <div class="card mx-auto text-center" style="max-width: 20vw">
                    <div class="card-header">
                        {{ $wish->book->title }}
                    </div>
                    <div class="card-body">
                        <img src="{{ asset('storage/' . $wish->book->cover) }}" alt="Imagen del Género" class="rounded"
                            style="max-height: 25vh">
                    </div>
                    <div class="  ms-1   mb-2 row">
                        <div class="col-7">
                            <a href="{{ route('books.show', $wish->book->id) }}" class="btn btn-primary">Ver Detalle</a>
                        </div>
                        <div class="col-5">
                            <form action="{{ route('wishes.remove', $wish->book_id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"><i class="bi bi-bookmark-fill"></i></button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
            <hr>
        @endforeach
    </div>
@endsection
