@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Crear Libro</h2>

        <!-- Formulario de creación de libros -->
        <form action="{{ route('books.store') }}" method="POST">
            @csrf

            {{-- Campos del formulario --}}
            <div class="form-group">
                <label for="author">Autor</label>
                <select id="author" class="form-control" name="author" style="width: 100%;">
                    {{-- Opciones de autores --}}
                    @foreach ($existingAuthors as $author)
                        <option value="{{ $author->id }}">{{ $author->name }} {{ $author->surnames }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="self_published">Auto-publicado</label>
                <input type="checkbox" name="self_published" id="self_published" value="1" required>
            </div>

            <div class="form-group">
                <label for="original_title">Título Original</label>
                <input type="text" name="original_title" id="original_title" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="cover">Portada</label>
                <input type="text" name="cover" id="cover" class="form-control">
            </div>

            <div class="form-group">
                <label for="visible">Visible</label>
                <input type="checkbox" name="visible" id="visible" value="1" required>
            </div>

            {{-- Selección de géneros --}}
            <div class="form-group">
                <label for="genres">Géneros</label>
                <select name="genres[]" id="genres" class="form-control" multiple>
                    {{-- Opciones de géneros --}}
                </select>
            </div>

            {{-- Botón de envío --}}
            <button type="submit" class="btn btn-primary">Crear Libro</button>
        </form>
    </div>
    <script>
        // Configuración de Select2 para búsqueda de autores
        $(document).ready(function () {
            $('#author_id').select2({
                ajax: {
                    url: '{{ route('authors.search') }}',
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (author) {
                                return {
                                    id: author.id,
                                    text: author.name + ' ' + (author.surnames ? author.surnames : ''),
                                };
                            })
                        };
                    },
                    cache: true
                },
                placeholder: 'Selecciona o escribe un autor',
                minimumInputLength: 1
            });
        });
    </script>

@endsection
