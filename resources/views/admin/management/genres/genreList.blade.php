@extends('layouts.app') <!-- Asegúrate de tener una plantilla base en 'resources/views/layouts/admin.blade.php' -->

@section('content')
    <div class="container-fluid ms-0 me-0 px-4 py-3 mt-3">

        <div class="ms-3 mb-4 text-center p-2" style="background-color:rgba(247, 247, 247, 0.651)">
            <h1 class="display-4 fw-bold" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);">
                <img src="{{ asset('assets/images/logos/logo2.png') }}" alt="Logo" style="max-height: 10vh">
                <ins>
                    Gestón de subadministradores
                </ins>
            </h1>
        </div>

        <div class="mb-3 mx-5">
            <a href="{{ route('genres.create') }}" class="btn btn-primary">Añadir Género</a>
            <a href="{{ route('books.management') }}" class="btn btn-primary">Volver</a>
        </div>

        <div class="table-responsive px-5">
            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($genres as $genre)
                        <tr>
                            <td>
                                @if (isset($genre) && $genre->img_url)
                                    <img src="{{ asset('storage/' . $genre->img_url) }}" alt="Imagen del Género"
                                        class="rounded" style="max-height: 40px; margin-left: 5vw">
                                @else
                                    No imagen
                                @endif
                            </td>
                            <td>{{ $genre->genre_name }}</td>
                            <td>{{ $genre->description }}</td>
                            <td>
                                <a href="{{ route('genres.edit', $genre->id) }}" class="btn btn-primary">Editar</a>

                                <!-- Botón de Borrar con Modal de Confirmación -->
                                <button type="button" class="btn btn-danger delete-genre-btn" data-bs-toggle="modal"
                                    data-bs-target="#confirmDeleteModal{{ $genre->id }}">
                                    Borrar
                                </button>

                                <!-- Modal de Confirmación de Borrado -->
                                <div class="modal fade" id="confirmDeleteModal{{ $genre->id }}" tabindex="-1"
                                    aria-labelledby="confirmDeleteModalLabel{{ $genre->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="confirmDeleteModalLabel{{ $genre->id }}">
                                                    Confirmar Borrado</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="text-dark">¿Seguro que quiere borrar este género?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancelar</button>
                                                <form action="{{ route('genres.destroy', ['id' => $genre->id]) }}"
                                                    method="post">
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
                            <td colspan="5">No hay géneros disponibles.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


    </div>

    <!-- Script para manejar el envío del formulario de borrado -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var deleteGenreModal = new bootstrap.Modal(document.querySelector('.delete-genre-btn'));

            // Evento para abrir el modal de confirmación y configurar el formulario antes de enviar
            $('.delete-genre-btn').on('click', function() {
                var genreId = $(this).data('genre-id');
                var deleteForm = $('#confirmDeleteForm' + genreId);

                deleteForm.attr('action', '/genres/' + genreId);
                deleteGenreModal.show();
            });

            // Evento para cerrar el modal después de enviar el formulario de borrado
            $('.confirm-delete-form').submit(function() {
                deleteGenreModal.hide();
            });
        });
    </script>
@endsection
