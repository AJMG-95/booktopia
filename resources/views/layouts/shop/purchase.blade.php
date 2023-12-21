@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Formulario de pago</h2>
        <form action="{{ route('purchase.make') }}" method="POST" id="payment-form">
            @csrf
            <input type="hidden" name="edition_id" value="{{ $edition->id }}">
            <div id="card_element">

            </div>
            <div class="mb-3">
                <label for="card-holder-name" class="form-label">
                    Nombre del titular de la tarjeta
                </label>
                <input type="text" class="form-control" id="card-holder-name" name="card-holder-name" required>
            </div>
            <div class="mb-3">
                <label for="payment-method" class="form-label">
                    Método de pago
                </label>
                <select class="form-control" id="payment_method" name="payment_method" required disabled>
                    <option value="card" selected>Tarjeta de crédito</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="card-holder-name" class="form-label">
                    Número de la tarjeta
                </label>
                <input type="text" class="form-control" id="card-number" name="card-number" required>
            </div>
            <div class="mb-3">
                <label for="card-cvv" class="form-label">
                    Código CVV
                </label>
                <input type="text" class="form-control" id="card-cvv" name="card-cvv" required>
            </div>
            <div class="mb-3">
                <label for="expiry" class="form-label">Fecha de expiración (MM/YY)</label>
                <input type="text" class="form-control" id="expiry" name="expiry" required>
            </div>
            <div class="mb-3">
                <label for="edition-price" class="form-label">
                    Precio
                </label>
                <input type="text" class="form-control" name="edition_price" id="edition_price"
                    value="{{ $edition->price }}" readonly>
            </div>
            <button type="submit" class="btn btn-primary" id="submit-button">Comprar</button>

        </form>
    </div>

@endsection
