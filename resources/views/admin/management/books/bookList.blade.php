@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Book List</h2>

        <!-- Mostrar mensajes de éxito o error aquí -->

        <div class="mb-3">
            <a href="{{ route('books.create') }}" class="btn btn-success">Añadir Libro</a>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Autores</th>
                    <th>Géneros</th>
                    <th>Autopublicado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($books as $book)
                    <tr>
                        <td>
                            @if ($book->cover)
                                <img src="{{ asset('assets/images/bookCovers/' . $book->cover) }}" alt="{{ $book->cover }}"
                                    class="img-thumbnail" style="max-height:5vh ">
                            @else
                                No Image
                            @endif
                        </td>
                        <td>{{ $book->id }}</td>
                        <td>{{ $book->original_title }}</td>
                        <td>
                            <select name="" id="">
                                @foreach ($book->authors as $author)
                                    <option value="">{{ $author->name }} {{ $author->surnames }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select name="" id="">
                                @foreach ($book->genres as $genre)
                                    <option value="">{{ $genre->genre }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>{{ $book->self_published ? 'Yes' : 'No' }}</td>
                        <td>
                            @if ($book->visible)
                                <form action="{{ route('books.toggleVisibility', $book->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-warning">Ocultar</button>
                                </form>
                            @else
                                <form action="{{ route('books.toggleVisibility', $book->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success">Mostrar</button>
                                </form>
                            @endif
                            <a href="{{ route('books.edit', $book->id) }}" class="btn btn-warning">
                                <i class="bi bi-pencil-square"></i> &nbsp; Editar
                            </a>
                            <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this book?')">
                                    <i class="bi bi-trash3"></i> &nbsp; Borrar
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">No se ha encontado ningún libro.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
