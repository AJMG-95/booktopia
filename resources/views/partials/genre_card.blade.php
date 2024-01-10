<div class="card">
    <img src="{{ $genre->img_url }}" class="card-img-top" alt="{{ $genre->genre_name }}">
    <div class="card-body">
        <h5 class="card-title">{{ $genre->genre_name }}</h5>
        <p class="card-text">Descripción: {{ $genre->description }}</p>
        <!-- Puedes agregar más detalles según sea necesario -->
        <a href="{{ route('genre.show', $genre->id) }}" class="btn btn-primary">Ver Género</a>
    </div>
</div>
