@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        <div class="mb-3">
            <a href="{{ route('books.create') }}" class="btn btn-primary me-2 mb-1">Añadir Libro</a>
            <a href="{{ route('books.management') }}" class="btn btn-primary mb-1">Volver</a>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th scope="col">ISBN</th>
                        <th scope="col">Título</th>
                        <th scope="col">Descripción Corta</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $book)
                        <tr>
                            <td>
                                @if (isset($book) && $book->cover)
                                    <img src="{{ asset('storage/' . $book->cover) }}" alt="Imagen del Género"
                                        class="rounded" style="max-height: 40px; margin-left: 5vw">
                                @else
                                    No imagen
                                @endif
                            </td>
                            <td>{{ $book->isbn }}</td>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->short_description }}</td>
                            <td>{{ $book->price }}</td>

                            <td>
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('books.edit', $book->id) }}" class="btn btn-primary me-1">Editar</a>
                                    <form action="{{ route('books.toggleVisibility', $book->id) }}" method="post"
                                        class="me-1">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">
                                            {{ $book->visible ? 'Ocultar' : 'Mostrar' }}
                                        </button>
                                    </form>
                                    <button type="button" class="btn btn-danger delete-book-btn me-1"
                                        data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $book->id }}">
                                        Borrar
                                    </button>
                                    <a href="{{ route('book.show', $book->id) }}" class="btn btn-info">Ver</a>
                                </div>
                            </td>



                            <!-- Modal de Confirmación de Borrado -->
                            <div class="modal fade" id="confirmDeleteModal{{ $book->id }}" tabindex="-1"
                                aria-labelledby="confirmDeleteModalLabel{{ $book->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="confirmDeleteModalLabel{{ $book->id }}">
                                                Confirmar Borrado</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="text-dark ">¿Seguro que quiere borrar este libro?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancelar</button>
                                            <form action="{{ route('books.destroy', $book->id) }}" method="POST"
                                                id="confirmDeleteForm{{ $book->id }}">
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
