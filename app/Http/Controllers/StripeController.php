<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Payment;
use Stripe\Customer;

class StripeController extends Controller
{
    public function stripe(Request $request)
    {
        // Set your secret key. Remember to switch to your live secret key in production.
        // See your keys here: https://dashboard.stripe.com/apikeys
        $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));

        $response = $stripe->checkout->sessions->create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => $request->title,
                        ],
                        'unit_amount' => $request->price * 100,
                    ],
                    'quantity' => (int)$request->quantity,
                ],
            ],
            'mode' => 'payment',
            'success_url' => route('success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('cancel'),
        ]);

        if (isset($response->id) && $response->id != "") {
            session()->put('product_name', $request->product_name);
            session()->put('product_id', $request->edition_id);
            session()->put('quantity', $request->quantity);
            session()->put('price', $request->price);

            return redirect($response->url);
        } else {
            return redirect()->route('cancel');
        }
    }

    public function success(Request $request)
    {
        if (isset($request->session_id)) {
            $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));
            $response = $stripe->checkout->sessions->retrieve($request->session_id);

            dd(session()->all());

            $payment = new Payment();
            $payment->payment_id = $response->id;
            $payment->edition_id = $request->edition_id;
            $payment->edition_name = $request->title;
            $payment->quantity = $request->quantity;
            $payment->amount = $request->price;
            $payment->user_id = auth()->id();
            $payment->currency = $response->currency;
            $payment->customer_name = $request->customer_name;
            $payment->customer_email = $request->customer_email;
            $payment->payment_status = $response->status;
            $payment->payment_method = "Stripe";
            $payment->save();


            session()->forget('product_name');
            session()->forget('quantity');
            session()->forget('price');

            return redirect()->route('shop')->with('success', 'Compra realizada con éxito.');
        } else {
            return redirect()->route('cancel');
        }
    }


    public function cancel()
    {
        return redirect()->route('shop')->with('error', 'La compra ha sido cancelada.');
    }
}
