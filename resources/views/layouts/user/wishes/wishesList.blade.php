@extends('layouts.app')

@section('content')
<div class="container-fluid ms-0 me-0 px-4 py-3 mt-3">

    <div class="ms-3 mb-4 text-center p-2" style="background-color:rgba(247, 247, 247, 0.651)">
        <h1 class="display-4 fw-bold" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);">
            <img src="{{ asset('assets/images/logos/logo2.png') }}" alt="Logo" style="max-height: 10vh" class="img-fluid">
            <ins>
                Bienvenido a tu lista de deseos
            </ins>
        </h1>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 justify-content-center">
        @forelse ($wishes as $wish)
            <div class="col mb-4">
                <div class="card border border-black rounded p-1"
                    style="background-color: rgba(247, 247, 247, 0.651)">
                    <div class="card-header text-center">
                        <h5 class="card-title">{{ $wish->book->title }}</h5>
                    </div>
                    <div class="card-body text-center">
                        <div class="overflow-hidden" style="max-width: 150px; max-height: 150px; margin: auto;">
                            <img src="{{ asset('storage/' . $wish->book->cover) }}"
                                class="card-img-top rounded-1 img-fluid" alt="{{ $wish->book->title }}"
                                style="object-fit: cover;">
                        </div>
                    </div>

                    <div class="card-footer text-center">
                        <div class="row">
                            <div class="col-6">
                                <a href="{{ route('books.details', $wish->book->id) }}"
                                    class="btn btn-primary btn-block"><i class="bi bi-eye"></i></a>
                            </div>
                            <div class="col-6">
                                <form action="{{ route('wishes.remove', $wish->book_id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-block">
                                        <i class="bi bi-bookmark-fill"></i>
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
