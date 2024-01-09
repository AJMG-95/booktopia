{{-- resources/views/components/editions/forBook.blade.php --}}

@extends('layouts.app') {{-- Ajusta según la estructura de tu layout --}}

@section('content')
    <div class="container-fluid mt-4 ms-4 p-4">
        <div class="mt-4 ms-4">
            <h1>Ediciones de "{{ $book->original_title }}"</h1>
        </div>
        <div class="row">
            @foreach ($editions as $edition)
                <div class="col-md-4">
                    <div class="card border rounded">
                        <div class="card-header">
                            <img src="{{ asset('assets/images/editionCovers/' . $edition->cover) }}" class="card-img-top" alt="Portada de la edición">
                        </div>
                        <div class="card-body rounded">
                            <h5 class="card-title">{{ $edition->title }}</h5>
                            <p class="card-text">{{ $edition->description }}</p>
                            <p class="card-text">ISBN: {{ $edition->isbn }}</p>
                            <p class="card-text">Editorial: {{ $edition->editorial }}</p>
                            <p class="card-text">Fecha de publicación: {{ $edition->publication_date }}</p>
                            <p class="card-text">Precio: {{ $edition->price }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
