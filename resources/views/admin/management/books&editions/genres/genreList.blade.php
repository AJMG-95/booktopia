<!-- resources/views/admin/management/books&editions/genres/genreList.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Genre List</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <a href="{{ route('genres.create') }}" class="btn btn-primary mb-2">Create Genre</a>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($genres as $genre)
                    <tr>
                        <td>{{ $genre->id }}</td>
                        <td>
                            @if ($genre->img_url)
                                <img src="{{ asset('assets/images/genres/' . $genre->img_url) }}" alt="{{ $genre->genre }}" class="img-thumbnail" style="max-height:5vh ">
                            @else
                                No Image
                            @endif
                        </td>
                        <td>{{ $genre->genre }}</td>
                        <td>{{ $genre->description }}</td>
                        <td>
                            <a href="{{ route('genres.edit', $genre->id) }}" class="btn btn-warning">
                                <i class="bi bi-pencil-square"></i> &nbsp; Editar
                            </a>
                            <form action="{{ route('genres.destroy', $genre->id) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this genre?')">
                                    <i class="bi bi-trash3"></i> &nbsp; Borrar
                                </button>

                            </form>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
