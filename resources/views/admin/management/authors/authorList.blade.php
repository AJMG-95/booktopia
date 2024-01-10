@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Gestión de autores</h2>

        <!-- Mostrar mensajes de éxito o error aquí -->

        <div class="mb-3">
            <a href="{{ route('authors.create') }}" class="btn btn-primary">Añadir Autor</a>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Nickname</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($authors as $author)
                    <tr>
                        <td>{{ $author->nickname }}</td>
                        <td>{{ $author->name }}</td>
                        <td>{{ $author->surnames }}</td>
                        <td>
                            <a href="{{ route('authors.edit', ['id' => $author->id]) }}" class="btn btn-warning">
                                <i class="bi bi-pencil-square"></i> &nbsp; Editar
                            </a>

                            <!-- Botón de Borrar con Modal de Confirmación -->
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-author-id="{{ $author->id }}">
                                <i class="bi bi-trash3"></i> &nbsp; Borrar
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No authors found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Modal de Confirmación de Borrado -->
        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Borrado</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-dark ">¿Seguro que quiere borrar este autor?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <form action="{{ route('authors.destroy', $author->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash3"></i> &nbsp; Borrar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para manejar el envío del formulario de borrado -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var confirmDeleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        });
    </script>
@endsection
