<!-- resources/views/admin/management/books&editions/genres/genreCreate.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Create Genre</h2>

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

        <form action="{{ route('genres.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="genre">Name:</label>
                <input type="text" class="form-control" id="genre" name="genre" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description"></textarea>
            </div>
            <div class="form-group">
                <label for="img_url">Image:</label>
                <input type="file" class="form-control" id="img_url" name="img_url" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Create Genre</button>
        </form>
    </div>
@endsection
