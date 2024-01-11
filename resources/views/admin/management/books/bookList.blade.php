@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        <div class="mb-3">
            <a href="{{ route('books.create') }}" class="btn btn-primary me-2">Añadir Libro</a>
            <a href="{{ route('books.management') }}" class="btn btn-primary">Volver</a>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ISBN</th>
                    <th scope="col">Título</th>
                    <th scope="col">Descripción Corta</th>
                    <th scope="col">Visible</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($books as $book)
                    <tr>
                        <td>{{ $book->isbn }}</td>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->short_description }}</td>
                        <td>{{ $book->visible ? 'Sí' : 'No' }}</td>
                        <td>
                            <a href="{{ route('books.edit', $book->id) }}" class="btn btn-primary">Editar</a>

                            <!-- Botón de Borrar con Modal de Confirmación -->
                            <button type="button" class="btn btn-danger delete-book-btn" data-bs-toggle="modal"
                                data-bs-target="#confirmDeleteModal{{ $book->id }}">
                                Borrar
                            </button>

                            <!-- Modal de Confirmación de Borrado -->
                            <div class="modal fade" id="confirmDeleteModal{{ $book->id }}" tabindex="-1"
                                aria-labelledby="confirmDeleteModalLabel{{ $book->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="confirmDeleteModalLabel{{ $book->id }}">Confirmar Borrado</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="text-dark ">¿Seguro que quiere borrar este libro?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <form action="{{ route('books.destroy', $book->id) }}" method="POST" id="confirmDeleteForm{{ $book->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Borrar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No hay libros disponibles.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Script para manejar el envío del formulario de borrado -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var deleteBookModal = new bootstrap.Modal(document.querySelector('.delete-book-btn'));

            // Evento para abrir el modal de confirmación y configurar el formulario antes de enviar
            $('.delete-book-btn').on('click', function() {
                var bookId = $(this).data('book-id');
                var deleteForm = $('#confirmDeleteForm' + bookId);

                deleteForm.attr('action', '/books/' + bookId);
                deleteBookModal.show();
            });

            // Evento para cerrar el modal después de enviar el formulario de borrado
            $('.confirm-delete-form').submit(function() {
                deleteBookModal.hide();
            });
        });
    </script>
@endsection
