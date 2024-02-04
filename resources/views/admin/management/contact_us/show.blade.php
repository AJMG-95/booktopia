<!-- resources/views/admin/contact_us/show.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container-fluid ms-0 me-0 px-4 py-3 mt-3">
        <div class="mb-4 text-center p-2 bg-light">
            <h1 class="display-4 fw-bold">
                <img src="{{ asset('assets/images/logos/logo2.png') }}" alt="Logo" style="max-height: 10vh" class="img-fluid">
                <ins>Notificaciones:</ins> {{ $message->title }}
            </h1>
        </div>

        <div class="px-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-subtitle text-white p-2">Título: {{ $message->title }}</h3>
                </div>
                <div class="card-body">
                    <h4><strong>De: <ins>{{ $message->sender_email }}</ins></strong></h4>
                    <div class="border border-black rounded p-2" style="min-height: 33vh">
                        {{ $message->body }}
                    </div>

                </div>
                <div class="card-footer">
                    <div class="form-group row mt-3 mb-3 ms-0 me-0 text-center">
                        <div class="col-md-6 ">
                            <form action="{{ route('contact_us.admin_toggle_status', $message->id) }}" method="post">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="btn {{ $message->status === 'open' ? 'btn-info' : 'btn-success' }}">
                                    {{ $message->status === 'open' ? 'Cerrar Mensaje' : 'Reabrir Mensaje' }}
                                </button>
                            </form>
                        </div>
                        <div class="col-md-6 ">
                            <a href="{{ route('contact_us.admin_index') }}" class="btn btn-danger">
                                {{ __('Volver') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
