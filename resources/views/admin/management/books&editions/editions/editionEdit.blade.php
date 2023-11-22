<!-- resources/views/admin/management/books&editions/editions/editionEdit.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Edition</h2>

        <!-- Mostrar mensajes de éxito o error aquí -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('editions.update', $edition->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Otros campos ... -->

            <div class="mb-3">
                <label for="price" class="form-label">Precio</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ $edition->price }}" required>
            </div>

            <!-- Otros campos ... -->

            <button type="submit" class="btn btn-primary">Actualizar Edición</button>
        </form>
    </div>
@endsection
