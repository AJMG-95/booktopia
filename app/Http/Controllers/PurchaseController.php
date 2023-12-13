<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Token;
use App\Models\Edition;

class PurchaseController extends Controller
{
    public function show($id)
    {
        $edition = Edition::findOrFail($id);
        $clientSecret = $this->getClientSecret($edition); // Reemplaza esto con la lógica real para obtener el clientSecret
        return view('layouts.shop.purchase', compact('edition', 'clientSecret'));
    }

    private function getClientSecret($edition)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SK'));

        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $edition->price * 100,
            'currency' => 'eur',
            'description' => 'Compra la edición: ' . $edition->title,
            'payment_method_types' => ['card'],
        ]);

        return $paymentIntent->client_secret;
    }

    public function make(Request $request)
    {
        $edition = Edition::findOrFail($request->edition_id);
        \Stripe\Stripe::setApiKey(env('STRIPE_SK'));

        try {
            list($expirationMonth, $expirationYear) = explode('/', $request->expiry);

            // Crear un token de tarjeta de prueba con Stripe.js
            $token = Token::create([
                'card' => [
                    'number' => $request->input('card-number'),
                    'exp_month' => $expirationMonth,
                    'exp_year' => $expirationYear,
                    'cvc' => $request->input('card-cvv'),
                ],
            ]);

            // Utilizar el token para crear un PaymentMethod
            $paymentMethod = \Stripe\PaymentMethod::create([
                'type' => 'card',
                'card' => [
                    'token' => $token->id,
                ],
            ]);

            // Confirma el PaymentIntent con el método de pago
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $edition->price * 100,
                'currency' => 'eur',
                'description' => 'Compra la edición: ' . $edition->title,
                'payment_method' => $paymentMethod->id,
                'confirmation_method' => 'manual',
                'confirm' => true,
                'return_url' => route('shop'), // Agregamos el return_url
            ]);

            // Guarda la información de la compra si es necesario

            // Retorna una respuesta exitosa con el client secret
            return response()->json([
                'success' => true,
                'clientSecret' => $paymentIntent->client_secret,
            ]);

        } catch (\Exception $e) {
            // Retorna una respuesta de error
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }

}
