{{-- resources/views/layouts/user/comments&posts/comments_posts.blade.php --}}

@extends('layouts.app') {{-- Ajusta según la estructura de tu layout --}}

@section('content')
    <div class="container-fluid ms-0 me-0 px-3 py-3 mt-2">
        <div class="ms-3 mb-4 text-center p-2" style="background-color:rgba(247, 247, 247, 0.651)">
            <h1 class="display-4 fw-bold" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);">
                <img src="{{ asset('assets/images/logos/logo2.png') }}" alt="Logo" style="max-height: 10vh" class="img-fluid">
                <ins>
                    Tus Posts y Comentarios
                </ins>
            </h1>
        </div>
        <div>
            @include('partials/user_posts', ['userComments' => $userComments])
        </div>
        <div>
            @include('partials/user_comments', ['userComments' => $userComments])
        </div>
    </div>
@endsection
