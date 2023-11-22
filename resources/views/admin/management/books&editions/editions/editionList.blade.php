<!-- resources/views/admin/management/books&editions/editions/editionList.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edition List</h2>

        <!-- Mostrar mensajes de éxito o error aquí -->
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

        <div class="mb-3">
            <a href="{{ route('editions.create') }}" class="btn btn-success">Añadir Edition</a>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th>ID</th>
                    <th>ISBN</th>
                    <th>Título</th>
                    <th>Editorial</th>
                    <th>Idioma</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($editions as $edition)
                    <tr>
                        <td>
                            <img src="{{ $edition->cover ? asset('assets/images/editionCovers/' . $edition->cover) : 'No Image' }}" alt="{{ $edition->cover }}"
                                class="img-thumbnail" style="max-height:5vh ">
                        </td>
                        <td>{{ $edition->id }}</td>
                        <td>{{ $edition->isbn }}</td>
                        <td>{{ $edition->title }}</td>
                        <td>{{ $edition->editorial }}</td>
                        <td>{{ $edition->language->language_name }}</td>
                        <td>{{ $edition->price }}</td>
                        <td>
                            <a href="{{ route('editions.edit', $edition->id) }}" class="btn btn-warning">
                                <i class="bi bi-pencil-square"></i> &nbsp; Editar
                            </a>
                            <form action="{{ route('editions.destroy', $edition->id) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this edition?')">
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

