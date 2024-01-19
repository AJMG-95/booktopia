<!-- resources/views/partials/dropzone_books.blade.php -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">Subir Libro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="border-bottom pt-3 ps-3 pe-3 text-center">
                <p><em> <b> Ojo:</b> si pones tu libro visible al público este tendrá un precio de 0,00 €</em></p>
            </div>

            <div class="modal-body">
                <!-- Dropzone Container -->
                <form action="{{ route('profile.publication.create') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <p class="form-label">Opciones de libro</p>
                        <input type="checkbox" class="form-check-input" id="for_adults" name="for_adults" value="1"
                            {{ old('for_adults') ? 'checked' : '' }}>
                        <label for="for_adults" class="form-label  me-3">Libro para adultos</label>
                        <input type="checkbox" class="form-check-input" id="visible" name="visible" value="1"
                            {{ old('visible') ? 'checked' : '' }}>
                        <label for="visible" class="form-label">Visible</label>
                    </div>


                    <div class="mb-3">
                        <label for="title" class="form-label">Título</label>
                        <input type="text" class="form-control" id="title" name="title"
                            value="{{ old('title') }}">
                    </div>


                    <div class="mb-3">
                        <label for="cover" class="form-label">Portada</label>
                        <input type="file" class="form-control" id="cover" name="cover">
                    </div>

                    <div class="mb-3">
                        <label for="document" class="form-label">Documento (PDF)</label>
                        <input type="file" class="form-control" id="document" name="document">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Autor</label>
                        <div style="max-height: 100px; overflow-y: auto;" class="bg-white rounded ps-1">
                            <input type="text" class="form-control" name=""
                                value="{{ $author->name . ', ' . $author->surnames }}" id="">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Géneros</label>
                        <div style="max-height: 100px; overflow-y: auto;" class="bg-white rounded ps-1 border">
                            @foreach ($genres as $genre)
                                <div class="form-check">
                                    <input class="form-check-input text-black border-black me-1" type="checkbox"
                                        id="genre_{{ $genre->id }}" name="genres[]" value="{{ $genre->id }}">
                                    <label class="form-check-label text-black" for="genre_{{ $genre->id }}">
                                        {{ $genre->genre_name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Idioma</label>
                        <select class="form-select" id="language_id" name="language_id">
                            @foreach ($languages as $language)
                                <option value="{{ $language->id }}"
                                    {{ old('language_id') == $language->id ? 'selected' : '' }}>
                                    {{ $language->language }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="short_description" class="form-label">Descripción Corta</label>
                        <textarea class="form-control" id="short_description" name="short_description">{{ old('short_description') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Descripción</label>
                        <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
                    </div>


                    <div class="mb-3">
                        <input type="text" hidden value="{{ $author->id }}" name="authors" id="authors">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
