{{-- resources/views/layouts/subscribe.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container-fluid ms-0 me-0 px-3 py-3 mt-2">
        <div class="ms-3 mb-4 text-center p-2" style="background-color:rgba(247, 247, 247, 0.651)">
            <h1 class="display-4 fw-bold" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);">
                <img src="{{ asset('assets/images/logos/logo2.png') }}" alt="Logo" style="max-height: 10vh">
                <ins>
                    Suscripción
                </ins>
            </h1>
        </div>

        @if (!Auth::user()->isSubscriber())
            <p>¡Suscríbete ahora y recibe descuentos exclusivos en tus compras!</p>
            <p>Precio de la suscripción: 20 €</p>

            {{-- Mensaje sobre descuentos (puedes personalizar este mensaje) --}}
            <p>Al suscribirte, recibirás descuentos especiales en todas tus compras.</p>

            {{-- Botón para confirmar la suscripción --}}
            <form action="{{ route('subscribe.confirm') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary mt-3">Confirmar Suscripción</button>
            </form>
        @else
            <div class="alert alert-primary mt-3 text-center">
                <h4 class="fw-bold">¡Usted ya está suscrito!</h4>
                <p class="fw-bold">Recuerde renovar su suscripción pasada la fecha de caducidad de su suscripción actual:
                </p>
                <p class="text-danger fw-bold">{{ Auth::user()->subscriber->end_at }}</p>
            </div>
        @endif
    </div>
@endsection
