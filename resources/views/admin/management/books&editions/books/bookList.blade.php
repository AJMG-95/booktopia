<!-- resources/views/admin/management/books/bookList.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Book List</h2>

        <!-- Mostrar mensajes de éxito o error aquí -->

        <div class="mb-3">
            <a href="{{ route('books.create') }}" class="btn btn-success">Añadir Book</a>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título </th>
                    <th>Autor/es</th>
                    <th>Género/s</th>
                    <th>Autopublicado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($books as $book)
                    <tr>
                        <td>{{ $book->id }}</td>
                        <td>{{ $book->original_title }}</td>
                        <td>
                            @foreach ($book->authors as $author)
                                {{ $author->name }}
                                {{ $loop->last ? '' : ', ' }}
                            @endforeach
                        </td>
                        <td>
                            @foreach ($book->genres as $genre)
                                {{ $genre->genre }}
                                {{ $loop->last ? '' : ', ' }}
                            @endforeach
                        </td>
                        <td>{{ $book->self_published ? 'Yes' : 'No' }}</td>
                        <td>
                            @if ($book->visible)
                                <form action="{{ route('books&editions.books.toggleVisibility', $book->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-warning">Ocultar</button>
                                </form>
                            @else
                                <form action="{{ route('books&editions.books.toggleVisibility', $book->id) }}"
                                    method="POST" style="display: inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success">Mostrar</button>
                                </form>
                            @endif
                            <a href="{{ route('books.edit', $book->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this book?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
