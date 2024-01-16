<?php

namespace App\Http\Controllers;

use App\Models\UserSubscriber;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UserSubscriberController extends Controller
{
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
