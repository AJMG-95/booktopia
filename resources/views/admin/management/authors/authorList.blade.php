@extends('layouts.app')

@section('content')
    <div class="container-fluid ms-0 me-0 px-4 py-3 mt-3">

        <div class="ms-3 mb-4 text-center p-2" style="background-color:rgba(247, 247, 247, 0.651)">
            <h1 class="display-4 fw-bold" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);">
                <img src="{{ asset('assets/images/logos/logo2.png') }}" alt="Logo" style="max-height: 10vh">
                <ins>
                    Gestón de Autores
                </ins>
            </h1>
        </div>

        <!-- Mostrar mensajes de éxito o error aquí -->

        <div class="mb-3 mx-5">
            <a href="{{ route('authors.create') }}" class="btn btn-primary me-3">Añadir Autor</a>
            <a href="{{ route('books.management') }}" class="btn btn-primary">Volver</a>
        </div>
        <div class="table-responsive px-5">
            <table class="table table-bordered table-striped table-hover rounded">
                <thead class="thead-dark" style="border-bottom: 2px solid #333;">
                    <tr>
                        <th class="text-center"></th>
                        <th class="text-center">Nombre</th>
                        <th class="text-center">Apellidos</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($authors as $author)
                        <tr style="border-bottom: 1px solid #33333363;">
                            <td class="text-center">
                                @if (isset($author) && $author->photo)
                                    <img src="{{ asset('storage/' . $author->photo) }}" alt="Imagen del Género"
                                        class="rounded ms-5" style="max-height: 40px;">
                                @else
                                    <i class="bi bi-person-circle rounded ms-5 "></i>
                                @endif
                            </td>
                            <td class="text-center">{{ $author->name }}</td>
                            <td class="text-center">{{ $author->surnames }}</td>
                            <td class="text-center">
                                <div class="btn-group" role="group" aria-label="Subadmin Actions">
                                    <a href="{{ route('authors.edit', $author->id) }}" class="btn btn-primary btn-sm me-2">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <!-- Botón de Borrar con Modal de Confirmación -->
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#confirmDeleteModal{{ $author->id }}">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </div>


                            </td>
                        </tr>
                        <!-- Modal de Confirmación de Borrado -->
                        <div class="modal fade" id="confirmDeleteModal{{ $author->id }}" tabindex="-1"
                            aria-labelledby="confirmDeleteModalLabel{{ $author->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmDeleteModalLabel{{ $author->id }}">
                                            Confirmar Borrado</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="text-dark">¿Seguro que quiere borrar este autor?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancelar</button>
                                        <form action="{{ route('authors.destroy', $author->id) }}" method="POST"
                                            id="confirmDeleteForm{{ $author->id }}">
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
                    @empty
                        <tr>
                            <td class="text-center" colspan="4">No authors found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

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
