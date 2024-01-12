@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Gestión de autores</h2>

        <!-- Mostrar mensajes de éxito o error aquí -->

        <div class="mb-3">
            <a href="{{ route('authors.create') }}" class="btn btn-primary">Añadir Autor</a>
            <a href="{{ route('books.management') }}" class="btn btn-primary">Volver</a>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($authors as $author)
                    <tr>
                        <td>
                            @if (isset($author) && $author->photo)
                                <img src="{{ asset('storage/' . $author->photo) }}" alt="Imagen del Género" class="rounded" style="max-height: 40px; margin-left: 5vw">
                            @else
                                No imagen
                            @endif
                        </td>
                        <td>{{ $author->name }}</td>
                        <td>{{ $author->surnames }}</td>
                        <td>
                            <a href="{{ route('authors.edit', $author->id) }}" class="btn btn-warning">
                                <i class="bi bi-pencil-square"></i> &nbsp; Editar
                            </a>

                            <!-- Botón de Borrar con Modal de Confirmación -->
                            <button type="button" class="btn btn-danger delete-author-btn" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $author->id }}">
                                <i class="bi bi-trash3"></i> &nbsp; Borrar
                            </button>

                            <!-- Modal de Confirmación de Borrado -->
                            <div class="modal fade" id="confirmDeleteModal{{ $author->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel{{ $author->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="confirmDeleteModalLabel{{ $author->id }}">Confirmar Borrado</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="text-dark">¿Seguro que quiere borrar este autor?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <form action="{{ route('authors.destroy', $author->id) }}" method="POST" id="confirmDeleteForm{{ $author->id }}">
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
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No authors found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Script para manejar el envío del formulario de borrado -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var deleteAuthorModal = new bootstrap.Modal(document.querySelector('.delete-author-btn'));

            // Evento para abrir el modal de confirmación y configurar el formulario antes de enviar
            $('.delete-author-btn').on('click', function() {
                var authorId = $(this).data('author-id');
                var deleteForm = $('#confirmDeleteForm' + authorId);

                deleteForm.attr('action', '/authors/' + authorId);
                deleteAuthorModal.show();
            });

            // Evento para cerrar el modal después de enviar el formulario de borrado
            $('.confirm-delete-form').submit(function() {
                deleteAuthorModal.hide();
            });
        });
    </script>
@endsection
