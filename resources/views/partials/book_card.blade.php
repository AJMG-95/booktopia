<div class="card">
    <img src="{{ $book->cover }}" class="card-img-top" alt="{{ $book->title }}">
    <div class="card-body">
        <h5 class="card-title">{{ $book->title }}</h5>
        <p class="card-text">ISBN: {{ $book->isbn }}</p>
        <p class="card-text">Editorial: {{ $book->editorial }}</p>
        <p class="card-text">Precio: ${{ $book->price }}</p>
        <p class="card-text">Descripción: {{ $book->short_description }}</p>
        <!-- Puedes agregar más detalles según sea necesario -->
        <a href="{{ route('book.show', $book->id) }}" class="btn btn-primary">Ver Detalles</a>
    </div>
</div>
