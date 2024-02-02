<!-- resources/views/admin/contact_us/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container-fluid ms-0 me-0 px-4 py-3 mt-3">

        <div class="ms-3 mb-4 text-center p-2" style="background-color:rgba(247, 247, 247, 0.651)">
            <h1 class="display-4 fw-bold" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);">
                <img src="{{ asset('assets/images/logos/logo2.png') }}" alt="Logo" style="max-height: 10vh">
                <ins>
                    Notificaciones
                </ins>
            </h1>
        </div>
        <div class="table-responsive px-5">
            <table class="table table-bordered table-striped table-hover rounded">
                <thead class="thead-dark" style="border-bottom: 2px solid #333;">
                    <tr>
                        <th class="text-center"></th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Asunto</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($messages as $message)
                        <tr style="border-bottom: 1px solid #33333363;">
                            <td class="text-center">{{ $message->id }}</td>
                            <td class="text-center">{{ $message->sender_email }}</td>
                            <td class="text-center">{{ $message->title }}</td>
                            <td class="text-center">
                                <div class="btn-group" role="group" aria-label="Genre Actions">
                                    <a href="{{ route('contact_us.admin_show', $message->id) }}"
                                        class="btn btn-primary me-2">Ver</a>

                                    @if ($message->status === 'open')
                                        <button type="button" class="btn btn-success rounded-end" data-bs-toggle="modal"
                                            data-bs-target="#closeModal{{ $message->id }}">
                                            Cerrar
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-info rounded-end" data-bs-toggle="modal"
                                            data-bs-target="#reopenModal{{ $message->id }}">
                                            Re-abrir
                                        </button>
                                    @endif



                                    <!-- Close Modal -->
                                    <div class="modal fade" id="closeModal{{ $message->id }}" tabindex="-1"
                                        aria-labelledby="closeModalLabel" aria-hidden="true">
                                        <!-- Add your close modal content here -->
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="closeModalLabel">Close Message</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Estas seguro/a de que deseas "cerrar" esta notificación?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <form action="{{ route('contact_us.admin_toggle_status', $message->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-success">Cerrar</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Reopen Modal -->
                                    <div class="modal fade" id="reopenModal{{ $message->id }}" tabindex="-1"
                                        aria-labelledby="reopenModalLabel" aria-hidden="true">
                                        <!-- Add your reopen modal content here -->
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="reopenModalLabel">Reopen Message</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Estas seguro/a de que deseas "re-abrir" esta notificación?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <form action="{{ route('contact_us.admin_toggle_status', $message->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-info">Re-abrir</button>
                                                    </form>
                                                </div>
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
    </div>
@endsection
