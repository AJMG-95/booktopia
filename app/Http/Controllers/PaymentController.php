<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\UserSubscriber;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class PaymentController extends Controller
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
            'success_url' => route('shop.payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('shop.payment.cancel'),
        ]);

        if (isset($response->id) && $response->id != "") {
            session()->put('product_name', $request->title);
            session()->put('product_id', $request->editionBook_id);
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
            /* dd($response); */

            $payment = new Payment();
            $payment->payment_id = $response->id;
            $payment->edition_name = session()->get('product_name');
            $payment->book_id = session()->get('product_id');
            $payment->quantity = session()->get('quantity');
            $payment->amount = session()->get('price');
            $payment->user_id = auth()->id();
            $payment->currency = $response->currency;
            $payment->customer_name = $response->customer_details->name;
            $payment->customer_email = $response->customer_details->email;
            $payment->payment_status = $response->status;
            $payment->payment_method = "Stripe";
            $payment->save();


            return redirect()->route('books.shop')->with('success', 'Compra realizada con éxito.');

            session()->forget('product_name');
            session()->forget('product_id');
            session()->forget('quantity');
            session()->forget('price');
            /* unset($request->session_id); */
        } else {
            return redirect()->route('cancel');
        }
    }


    public function cancel()
    {
        return redirect()->route('books.shop')->with('error', 'La compra ha sido cancelada.');
    }

    public function subscribe()
    {
        try {
            $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));

            $response = $stripe->checkout->sessions->create([
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'eur',
                            'product_data' => [
                                'name' => 'suscripcion' . Auth::id() . '_' . Auth::user()->nickname,
                            ],
                            'unit_amount' => 2000,
                        ],
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'payment',
                'success_url' => route('subscribe.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('subscribe.cancel'),
            ]);


            if (isset($response->id) && $response->id != "") {
                $productName = 'suscripcion' . Auth::id() . '_' . Auth::user()->nickname;
                $quantity = 1;
                $price = 20.00;
                session()->put('product_name', $productName);
                session()->put('quantity', $quantity);
                session()->put('price', $price);

                return redirect($response->url);
            } else {
                return redirect()->route('cancel');
            }
        } catch (\Exception $e) {
            return redirect()->route('subscribe.cancel')->with('error', 'Ha ocurrido un error durante la suscripción.');
        }
    }

    public function subscribeSuccess(Request $request)
    {
        if (isset($request->session_id)) {
            $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));
            $response = $stripe->checkout->sessions->retrieve($request->session_id);

            $userSubscriber = new UserSubscriber();
            $userSubscriber->user_id = auth()->id();
            // Establecer la fecha de caducidad desde la fecha de suscripción
            $userSubscriber->end_at = now()->addDays(30);
            $userSubscriber->is_active = true;
            $userSubscriber->save();

            return redirect()->route('subscribe.view')->with('success', 'Suscripción realizada con éxito.');

            session()->forget('product_name');
            session()->forget('quantity');
            session()->forget('price');
            /* unset($request->session_id); */

        } else {
            return redirect()->route('cancel');
        }
    }

    public function subscribeCancel()
    {
        return redirect()->route('subscribe.view')->with('error', 'La suscripción ha sido cancelada.');
    }

    public function subscribeView()
    {
        return view('layouts/subscribe');
    }

    public function subscribeConfirm()
    {
        return $this->subscribe();
    }
}
