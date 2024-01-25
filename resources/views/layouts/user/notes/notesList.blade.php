<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Notes</title>

    @vite(['resources/css/layouts/notesList.css'])
</head>

<body>

    @extends('layouts.app')

    @section('content')
        <div class="container-fluid ms-0 me-0 px-4 py-3 mt-3">
            <div class="ms-3 mb-4 text-center p-2" style="background-color:rgba(247, 247, 247, 0.651)">
                <ins>
                    <h1 class="display-4 fw-bold" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);">
                        Mis Notas
                    </h1>
                </ins>
            </div>

            <div class="ms-5 mt-3">
                <a href="{{ route('sticky_note.create') }}" class="btn btn-primary">Crear Nueva Nota</a>
            </div>



            @if (count($userNotes) > 0)
                <ul class="note-list">
                    @foreach ($userNotes as $note)
                        <li class="note-card">
                            <div class="note-content">
                                <h2>{{ $note->title }}</h2>
                                <div class="note-actions row mt-5">
                                    <a href="{{ route('sticky_note.show', $note) }}" class="showBtn col-1">Ver</a>
                                    <form action="{{ route('sticky_note.destroy', $note) }}" method="POST" class="col-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="deleteBtn"
                                            onclick="return confirm('¿Estás seguro de eliminar esta nota?')">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class=" text-center m-auto p-auto">
                    <p class="">No tienes ninguna nota.</p>

                </div>
            @endif
        </div>
    @endsection

</body>

</html>
