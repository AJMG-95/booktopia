@extends('layouts.app') <!-- Asegúrate de tener una plantilla base en 'resources/views/layouts/admin.blade.php' -->

@section('content')
    <div class="container mt-4">

        <div class="mb-3">
            <a href="{{ route('genres.create') }}" class="btn btn-primary">Añadir Genero</a>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Imagen</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($genres as $genre)
                    <tr>
                        <td>{{ $genre->genre_name }}</td>
                        <td>{{ $genre->description }}</td>
                        <td>
                            @if (isset($genre) && $genre->img_url)
                                <img src="{{ asset('storage/' . $genre->img_url) }}" alt="Imagen del Género">
                            @else
                                No imagen
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('genres.edit', $genre->id) }}" class="btn btn-primary">Editar</a>

                            <!-- Botón de Borrar con Modal de Confirmación -->
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#confirmDeleteModal" data-genre-id="{{ $genre->id }}">
                                Borrar
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No hay géneros disponibles.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Modal de Confirmación de Borrado -->
        @if (isset($genre))
            <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Borrado</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p class="text-dark ">¿Seguro que quiere borrar este género?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <form action="{{ route('genres.destroy', ['id' => $genre->id]) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Borrar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>


    <!-- Script para manejar el envío del formulario de borrado -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var confirmDeleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        });
    </script>
@endsection
