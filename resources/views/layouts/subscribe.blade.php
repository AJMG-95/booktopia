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

        @if (!Auth::user()->isAdmin() && !Auth::user()->isSubadmin())
            @if (!Auth::user()->isSubscriber())
                <div class="text-center mt-5">
                    <h3 class="">¡Suscríbete ahora y recibe descuentos exclusivos en tus compras!</h3>
                    <h4><strong> Precio de la suscripción: <span class="text-success">20 €</span></strong> </h4>

                    {{-- Mensaje sobre descuentos (puedes personalizar este mensaje) --}}
                    <h5>Al suscribirte, recibirás descuentos especiales en todas tus compras.</h5>

                    {{-- Botón para confirmar la suscripción --}}
                    <form action="{{ route('subscribe.confirm') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary mt-3">Confirmar Suscripción</button>
                    </form>
                </div>
            @else
                <div class="alert alert-primary mt-5 text-center">
                    <h3 class="fw-bold">¡Usted ya está suscrito!</h3>
                    <h4 class="fw-bold">Recuerde renovar su suscripción pasada la fecha de caducidad de su suscripción
                        actual:
                    </h4>
                    <h5 class="text-danger fw-bold">{{ Auth::user()->subscriber->end_at }}</>
                </div>
            @endif
        @else
            <div class="text-center mt-5">
                <h3 class="">¡Los perfiles de administración de la web no pueden suscribirse!</h3>
            </div>
        @endif
        <div class="text-center mt-3">
            <a href="{{ url()->previous() }}" class="btn btn-danger">Volver</a>
        </div>
    </div>
@endsection
