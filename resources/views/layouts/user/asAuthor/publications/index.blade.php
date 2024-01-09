@extends('layouts.app')

@section('content')
    <div class="container m-4">
        <h1>Mis Publicaciones</h1>

        <a href="{{ route('publications.create') }}" class="btn btn-primary mt-2">Publicar Nueva Edición</a>
        @if($editions->count() > 0)
            <ul>
                @foreach($editions as $edition)
                    <li>
                        <h3>{{ $edition->title }}</h3>
                        <p>{{ $edition->description }}</p>
                        <!-- Agrega aquí cualquier otra información que quieras mostrar -->
                    </li>
                @endforeach
            </ul>
        @else
            <p>Aún no tienes publicaciones.</p>
        @endif

    </div>
@endsection
