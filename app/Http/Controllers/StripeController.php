//StripeController.php:
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class StripeController extends Controller
{
    public function index()
    {
        return view(view: 'index');
    }

    public function checkout()
    {
        \Stripe\Stripe::setApiKey(config(key: 'stripe.sk'));

        $session = \Stripe\Checkout\Session::create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'gdp',
                        'product_data' => [
                            'name' => 'Send me money!!!'
                        ],
                        'unit_amount' => 500,
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => route(name: 'success'),
            'cancel_url' => route(name: 'index'),
        ]);

        return redirect()->away($session->url);
    }

    public function success()
    {
        return view(view: 'index');
    }
}


// views/layouts/index.blade.php:
<form action="/checkout" method="POST">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <button type="submit">Checkout</button>
</form>



//Web.php:
Route::get(uri:'/', action: 'App\Http\Controllers\StripeController@index')->name(name: 'index');
Route::post(uri:'/checkout', action: 'App\Http\Controllers\StripeController@checkout')->name(name: 'checkout');;
Route::get(uri:'/success', action: 'App\Http\Controllers\StripeController@success')->name(name: 'success');


// config/stripe.php:
<?php
return [
    'sk' => env(key: 'STRIPE_SK'),
    'pk' => env(key: 'STRIPE_PK')
];
