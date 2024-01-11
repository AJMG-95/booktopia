<!-- resources/views/admin/management/users/userList.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Gestón de usuarios</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-3">
            <a href="{{ route('user.create') }}" class="btn btn-primary me-3">Create User</a>
            <a href="{{ route('home') }}" class="btn btn-primary">Volver</a>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nickname</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->nickname }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning">Edit</a>

                            <!-- Botón de Borrar con Modal de Confirmación -->
                            <button type="button" class="btn btn-danger delete-user-btn" data-bs-toggle="modal"
                                data-bs-target="#confirmDeleteModal{{ $user->id }}">
                                Delete
                            </button>

                            <!-- Modal de Confirmación de Borrado -->
                            <div class="modal fade" id="confirmDeleteModal{{ $user->id }}" tabindex="-1"
                                aria-labelledby="confirmDeleteModalLabel{{ $user->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="confirmDeleteModalLabel{{ $user->id }}">Confirm Delete</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="text-dark">Are you sure you want to delete this user?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <a href="{{ route('user.delete', $user->id) }}" class="btn btn-danger">
                                                Confirm Delete
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Script para manejar el envío del formulario de borrado -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var deleteUserModal = new bootstrap.Modal(document.querySelector('.delete-user-btn'));

            // Evento para abrir el modal de confirmación
            $('.delete-user-btn').on('click', function() {
                var userId = $(this).data('user-id');
                var deleteForm = $('#confirmDeleteForm' + userId);

                deleteForm.attr('action', '/user/' + userId);
                deleteUserModal.show();
            });
        });
    </script>
@endsection
