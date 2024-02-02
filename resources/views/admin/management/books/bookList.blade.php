@extends('layouts.app')

@section('content')
    <style>
        .text-truncate {
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            max-width: 150px;
            /* Adjust the max-width as needed */
        }
    </style>
    <div class="container-fluid ms-0 me-0 px-4 py-3 mt-3">

        <div class="ms-3 mb-4 text-center p-2" style="background-color:rgba(247, 247, 247, 0.651)">
            <h1 class="display-4 fw-bold" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);">
                <img src="{{ asset('assets/images/logos/logo2.png') }}" alt="Logo" style="max-height: 10vh">
                <ins>
                    Gestón de Libros
                </ins>
            </h1>
        </div>

        <div class="mb-3 mx-5">
            <a href="{{ route('books.create') }}" class="btn btn-primary me-2 mb-1">Añadir Libro</a>
            <a href="{{ route('books.management') }}" class="btn btn-primary mb-1">Volver</a>
        </div>

        <div class="table-responsive px-5">
            <table class="table table-bordered table-striped table-hover rounded">
                <thead class="thead-dark" style="border-bottom: 2px solid #333;">
                    <tr>
                        <th class="text-center"></th>
                        <th class="text-center" scope="col">Título</th>
                        <th class="text-center" scope="col">Descripción Corta</th>
                        <th class="text-center" scope="col">Precio</th>
                        <th class="text-center" scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $book)
                        <tr style="border-bottom: 1px solid #33333363;">
                            <td class="text-center">
                                @if (isset($book) && $book->cover)
                                    <img src="{{ asset('storage/' . $book->cover) }}" alt="Imagen del Género"
                                        class="rounded" style="max-height: 40px; ">
                                @else
                                    No imagen
                                @endif
                            </td>
                            <td class="text-center">{{ $book->title }}</td>
                            <td class="text-center text-truncate">{{ $book->short_description }}</td>
                            <td class="text-center">{{ $book->price ? number_format($book->price, 2, ',', '.') : '0,00' }}</td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center">
                                    <form action="{{ route('books.toggleVisibility', $book->id) }}" method="post"
                                        class="me-1">
                                        @csrf
                                        <button type="submit"
                                            class="btn btn-{{ $book->visible ? 'secondary' : 'success' }} btn-sm">
                                            {{ $book->visible ? 'Ocultar' : 'Mostrar' }}
                                        </button>
                                    </form>
                                    <div class="btn-group" role="group" aria-label="Subadmin Actions">
                                        <a href="{{ route('books.edit', $book->id) }}"
                                            class="btn btn-primary btn-sm me-1"><i class="bi bi-pencil"></i></a>
                                        <a href="{{ route('books.show', $book->id) }}" class="btn btn-info btn-sm me-1"> <i
                                                class="bi bi-eye"></i></a>
                                        <button type="button" class="btn btn-danger btn-sm " data-bs-toggle="modal"
                                            data-bs-target="#confirmDeleteModal{{ $book->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>



                            </td>
                        </tr>

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
