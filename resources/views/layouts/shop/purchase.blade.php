@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Realizar Compra</div>

                    <div class="card-body">
                        <h2>{{ $edition->book->title }}</h2>
                        <p><strong>Autor:</strong> {{ $edition->book->authors->pluck('name')->implode(', ') }}</p>
                        <p><strong>Género:</strong> {{ $edition->book->genres->pluck('genre')->implode(', ') }}</p>
                        <p><strong>Precio:</strong> €{{ $edition->price }}</p>

                        <form action="{{ route('purchase.process', ['id' => $edition->id]) }}" method="post" id="payment-form">
                            @csrf
                            <div id="card-element">
                                <!-- Elemento donde se mostrará el formulario de Stripe -->
                            </div>

                            <!-- Se muestra el resultado de la validación -->
                            <div id="card-errors" role="alert"></div>

                            <!-- Hidden input para almacenar el PaymentMethod ID -->
                            <input type="hidden" name="payment_method" id="payment_method">

                            <div class="form-group mt-3">
                                <label for="card_holder_name">Nombre del titular de la tarjeta</label>
                                <input type="text" name="card_holder_name" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="expiration_date">Fecha de caducidad</label>
                                <input type="text" name="expiration_date" class="form-control" placeholder="MM/YY" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Realizar Pago</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        var stripe = Stripe('{{ config('services.stripe.key') }}');
        var elements = stripe.elements();

        var style = {
            base: {
                fontSize: '16px',
                color: '#32325d',
            },
        };

        var card = elements.create('card', { style: style });
        card.mount('#card-element');

        card.addEventListener('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        var form = document.getElementById('payment-form');

        form.addEventListener('submit', function(event) {
            event.preventDefault();

            stripe.createPaymentMethod({
                type: 'card',
                card: card,
            }).then(function(result) {
                if (result.error) {
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    document.getElementById('payment_method').value = result.paymentMethod.id;
                    form.submit();
                }
            });
        });
    </script>
@endsection
