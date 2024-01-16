{{-- resources/views/layouts/subscribe.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container p-4">
        <h2>Suscripción</h2>
        <p>¡Suscríbete ahora y recibe descuentos exclusivos en tus compras!</p>
        <p>Precio de la suscripción: 20 €</p>

        {{-- Mensaje sobre descuentos (puedes personalizar este mensaje) --}}
        <p>Al suscribirte, recibirás descuentos especiales en todas tus compras.</p>

        {{-- Botón para confirmar la suscripción --}}
        <form action="{{ route('subscribe.confirm') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">Confirmar Suscripción</button>
        </form>
    </div>
@endsection
