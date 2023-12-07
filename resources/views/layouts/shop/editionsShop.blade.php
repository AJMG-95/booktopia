@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            {{-- Menú lateral de filtros --}}
            <aside class="col-lg-3 col-md-4 pt-4">
                <h2>Buscar...</h2>
                <form action="{{  route('shop')  }}" method="GET" class="p-3">
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" name="title" class="form-control" placeholder="Buscar por Título" />
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" name="author" class="form-control" placeholder="Buscar por Autor">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="bi bi-bookmark"></i></span>
                        <input type="text" name="genre" class="form-control" placeholder="Buscar por Genero">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">(max.) €</span>
                        <input type="number" name="max_price" class="form-control">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">(min.) €</span>
                        <input type="number" name="min_price" class="form-control">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="bi bi-upc-scan"></i></span>
                        <input type="text" name="isbn" class="form-control" placeholder="ISBN">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="autopublicado" value="0" class="form-check-input">
                        <label for="autopublicado">Mostrar solo libros autopublicados</label>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-block"> Aplicar Filtros </button>
                    </div>
                </form>
            </aside>

            {{-- Área principal para mostrar los libros --}}
            <main class="col-lg-9 col-md-8 pt-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <select name="shortBy" class="form-select w-auto">
                        <option value="asc_price">Menor a mayor €</option>
                        <option value="desc_price">Mayor a menor €</option>
                        <option value="asc_title">A-Z</option>
                        <option value="desc_title">Z-A</option>
                        <option value="publication_date">Más reciente</option>
                    </select>
                </div>
                <div class="row row-cols-1 row-cols-md-3 g4">
                    @foreach ($editions as $edition)
                        <div class="col">
                            <div class="card h-100">
                                <img src="{{ $edition->cover }}" class="card-img-top" alt="{{ $edition->title }}">
                                <div class="card-body">
                                    <h5>{{ $edition->title }}</h5>
                                    <p class="card-text">
                                        <strong>Autor:</strong> {{ $edition->book->author->name }}
                                    </p>
                                    <p class="card-text">
                                        <strong>Género:</strong> {{ $edition->book->genres->implode('name', ', ') }}
                                    </p>
                                    <p class="card-text">{{ $edition->short_description }} </p>
                                </div>
                                <div class="card-footer">
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input" id="wishes{{ $edition->id }}"
                                            onchange="toggleWishes({{ $edition->id }})">
                                        <label class="form-check-label" for="wishes{{ $edition->id }}">Deseo</label>
                                    </div>
                                    <button class="">Comprar</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </main>
        </div>
    </div>
    <script>
        function toggleWishes(edicionId) {
            var checkbox = document.getElementById('wishes' * libroId);
            //Aquí deberías hacer una solcitud AJAX a tu servidor para actualizar la lista de deseos
            if (checkbox.checked) {
                //Código para añadir el libro a deseos
            } else {
                //Código para eliminar del listado de deseos
            }
        }
    </script>
@endsection
