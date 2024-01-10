<!-- resources/views/admin/management/books&editions/genres/genreEdit.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Genre</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('genres.update', $genre->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="genre">Name:</label>
                <input type="text" class="form-control" id="genre" name="genre" value="{{ $genre->genre }}" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description">{{ $genre->description }}</textarea>
            </div>
            <div class="form-group">
                <label for="img_url">Imagen Actual:</label>
                <img src="{{ asset('assets/images/genres/' . $genre->img_url) }}" alt="{{ $genre->genre }}" class="img-thumbnail" style="max-height: 7vh">
            </div>
            <div class="form-group">
                <label for="new_img_url">New Image (optional):</label>
                <input type="file" class="form-control" id="new_img_url" name="new_img_url" accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary">Update Genre</button>
        </form>
    </div>
@endsection
