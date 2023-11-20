<!-- resources/views/admin/management/books/bookCreate.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Create Book</h2>

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

        <form action="{{ route('books.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="original_title">Original Title:</label>
                <input type="text" class="form-control" id="original_title" name="original_title" required>
            </div>

            <!-- Selección múltiple de autores -->
            <div class="form-group">
                <label for="authors">Authors:</label>
                <select id="authors" name="authors[]" class="form-control" multiple size="4">
                    @foreach ($authors as $author)
                        <option value="{{ $author->id }}">{{ $author->name }} {{$author->surnames}}</option>
                    @endforeach
                </select>
                <button type="button" id="addAuthorBtn" class="btn btn-primary mt-2">Add Selected Authors</button>
                <div id="selectedAuthors" class="mt-2"></div>
            </div>

            <!-- Selección múltiple de géneros -->
            <div class="form-group">
                <label for="genres">Genres:</label>
                <select id="genres" name="genres[]" class="form-control" multiple size="4">
                    @foreach ($genres as $genre)
                        <option value="{{ $genre->id }}">{{ $genre->genre }}</option>
                    @endforeach
                </select>
                <button type="button" id="addGenreBtn" class="btn btn-primary mt-2">Add Selected Genres</button>
                <div id="selectedGenres" class="mt-2"></div>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description"></textarea>
            </div>

            <div class="form-group">
                <label for="published_date">Published Date:</label>
                <input type="date" class="form-control" id="published_date" name="published_date">
            </div>

            <div class="form-group">
                <label for="cover_image">Cover Image:</label>
                <input type="file" class="form-control" id="cover_image" name="cover_image" accept="image/*" required>
            </div>

            <div class="form-group">
                <label for="self_published">Self Published:</label>
                <input type="checkbox" class="form-check" id="self_published" name="self_published" value="1">
            </div>

            <div class="form-group">
                <label for="visible">Visible:</label>
                <input type="checkbox" class="form-check" id="visible" name="visible" value="1">
            </div>


            <button type="submit" class="btn btn-success mt-3">Create Book</button>
        </form>
    </div>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet"/>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            var selectedAuthors = [];
            var selectedGenres = [];

            // Evento de clic en el botón para autores
            $('#addAuthorBtn').click(function () {
                var selectedAuthorsList = $('#authors option:selected');
                selectedAuthorsList.each(function (index, element) {
                    var authorId = $(element).val();
                    if (!selectedAuthors.includes(authorId)) {
                        selectedAuthors.push(authorId);
                    }
                });
                updateSelectedAuthors();
            });

            // Evento de clic en el botón para géneros
            $('#addGenreBtn').click(function () {
                var selectedGenresList = $('#genres option:selected');
                selectedGenresList.each(function (index, element) {
                    var genreId = $(element).val();
                    if (!selectedGenres.includes(genreId)) {
                        selectedGenres.push(genreId);
                    }
                });
                updateSelectedGenres();
            });

            // Función para actualizar la lista de autores seleccionados
            function updateSelectedAuthors() {
                $('#selectedAuthors').html('<strong>Selected Authors:</strong> ' + selectedAuthors.join(', '));
            }

            // Función para actualizar la lista de géneros seleccionados
            function updateSelectedGenres() {
                $('#selectedGenres').html('<strong>Selected Genres:</strong> ' + selectedGenres.join(', '));
            }
        });
    </script>
@endsection
