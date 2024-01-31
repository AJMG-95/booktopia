<!-- resources/views/admin/management/users/userList.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container-fluid ms-0 me-0 px-4 py-3 mt-3">

        <div class="ms-3 mb-4 text-center p-2" style="background-color:rgba(247, 247, 247, 0.651)">
            <h1 class="display-4 fw-bold" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);">
                <img src="{{ asset('assets/images/logos/logo2.png') }}" alt="Logo" style="max-height: 10vh">
                <ins>
                    Gestón de usuarios
                </ins>
            </h1>
        </div>

        <div class="mb-3 mx-5">
            <a href="{{ route('user.create') }}" class="btn btn-primary me-3">Crear Usuario</a>
            <a href="{{ route('home') }}" class="btn btn-primary">Volver</a>
        </div>

        <div class="table-responsive px-5">
            <table class="table table-bordered table-striped table-hover rounded">
                <thead class="thead-dark" style="border-bottom: 2px solid #333;">
                    <tr>
                        <th></th>
                        <th>Nickname</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr style="border-bottom: 1px solid #33333363;">
                            <td class="text-center">{{ $user->id }}</td>
                            <td>{{ $user->nickname }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td class="text-center">
                                <div class="btn-group" role="group" aria-label="User Actions">
                                    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary btn-sm me-2"
                                        title="Edit User">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form action="{{ route('user.toggleBlock', $user->id) }}" method="POST"
                                        class="d-inline me-2">
                                        @csrf
                                        @method('PUT')

                                        @if ($user->blocked)
                                            <button type="submit" class="btn btn-info btn-sm" title="Unblock User">
                                                <i class="bi bi-unlock"></i>
                                            </button>
                                        @else
                                            <button type="submit" class="btn btn-success btn-sm" title="Block User">
                                                <i class="bi bi-lock"></i>
                                            </button>
                                        @endif
                                    </form>

                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#confirmDeleteModal{{ $user->id }}" title="Delete User">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>

                            </td>
                        </tr>
                        <!-- Modal de Confirmación de Borrado -->
                        <div class="modal fade" id="confirmDeleteModal{{ $user->id }}" tabindex="-1"
                            aria-labelledby="confirmDeleteModalLabel{{ $user->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmDeleteModalLabel{{ $user->id }}">
                                            Confirmar Borrado</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="text-dark ">¿Seguro que quiere borrar este usuario?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancelar</button>
                                        <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                            id="confirmDeleteForm{{ $user->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Borrar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>


    </div>

    <!-- Script para manejar el envío del formulario de borrado -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var deleteBookModal = new bootstrap.Modal(document.querySelector('.delete-user-btn'));

            // Evento para abrir el modal de confirmación y configurar el formulario antes de enviar
            $('.delete-user-btn').on('click', function() {
                var userId = $(this).data('user-id');
                var deleteForm = $('#confirmDeleteForm' + userId);

                deleteForm.attr('action', '/user/' + userId);
                deleteBookModal.show();
            });

            // Evento para cerrar el modal después de enviar el formulario de borrado
            $('.confirm-delete-form').submit(function() {
                deleteBookModal.hide();
            });
        });
    </script>
@endsection
