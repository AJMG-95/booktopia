<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    @vite(['resources/css/layouts/notesShow.css'])
</head>

<body>

    @extends('layouts.app')

    @section('content')
    <div class="container mt-5">
        <h1>Detalles de la Nota</h1>

        <div class="note-container">

            <h2>{{ $stickyNote->title }}</h2>
            <p>{{ $stickyNote->body }}</p>

            <p>Creada por: {{ $stickyNote->user->name }}</p>

            <button class="edit-link">
                <a href="{{ route('notes.edit', $stickyNote) }}">
                    <i class="bi bi-pencil-square" style="color: #fff"></i>
                </a>
            </button>

            <form action="{{ route('notes.destroy', $stickyNote) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('¿Estás seguro de eliminar esta nota?')" class="del"><i
                        class="bi bi-trash3-fill"></i></button>
            </form>

            <button class="back-link">
                <a href="{{ route('notes.index') }}" class="cancel-link">
                    <svg fill="#ffffff" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" width="25px" height="25px" viewBox="0 0 300 300"
                        xml:space="preserve" stroke="#000000" stroke-width="0.0029902100000000005">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke=""
                            stroke-width="11"></g>
                        <g id="SVGRepo_iconCarrier">
                            <g>
                                <g>
                                    <path
                                    d="M292.866,254.432c-2.288,0-4.443-1.285-5.5-3.399c-0.354-0.684-28.541-52.949-146.169-54.727v51.977 c0,2.342-1.333,4.48-3.432,5.513c-2.096,1.033-4.594,0.793-6.461-0.63L2.417,154.392C0.898,153.227,0,151.425,0,149.516 c0-1.919,0.898-3.72,2.417-4.888l128.893-98.77c1.87-1.426,4.365-1.667,6.461-0.639c2.099,1.026,3.432,3.173,3.432,5.509v54.776 c3.111-0.198,7.164-0.37,11.947-0.37c43.861,0,145.871,13.952,145.871,143.136c0,2.858-1.964,5.344-4.75,5.993 C293.802,254.384,293.34,254.432,292.866,254.432z">
                                </path>
                                </g>
                            </g>
                        </g>
                    </svg>
                </a>
            </button>
        </div>
    </div>
        @endsection
    </body>

    </html>
