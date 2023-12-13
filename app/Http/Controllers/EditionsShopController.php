<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Stripe\Stripe;
use Stripe\PaymentIntent;

use App\Models\Edition;
use App\Models\Author;
use App\Models\Genre;
use App\Models\Invoice;
use App\Models\CreditCard;



class EditionsShopController extends Controller
{
    public function index(Request $request)
    {
        // Construir la consulta principal para las ediciones
        $query = Edition::query();

        // Incluir relaciones necesarias para evitar consultas N+1
        $query->with(['book.authors', 'language']); // Corrección: 'book.author' a 'book.authors'

        // Aplicar filtros según los parámetros de la solicitud
        if ($request->has('title')) {
            $query->where('title', 'like', '%' . $request->get('title') . '%');
        }

        if ($request->has('author')) {
            $query->whereHas('book.authors', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->get('author') . '%');
            });
        }

        if ($request->has('genre')) {
            $query->whereHas('book.genres', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->get('genre') . '%');
            });
        }

        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->get('max_price'));
        }

        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->get('min_price'));
        }

        // Otros filtros...

        // Ordenar resultados según la condición seleccionada
        $orderBy = $request->get('sortBy', 'asc_price');

        switch ($orderBy) {
            case 'asc_price':
                $query->orderBy('price', 'asc');
                break;
            case 'desc_price':
                $query->orderBy('price', 'desc');
                break;
            case 'asc_title':
                $query->orderBy('title', 'asc');
                break;
            case 'desc_title':
                $query->orderBy('title', 'desc');
                break;
            case 'publication_date':
                $query->orderBy('publication_date', 'desc');
                break;
                // Agrega más casos según sea necesario
        }

        // Obtener las ediciones resultantes
        $editions = $query->get();

        // También puedes cargar información adicional si es necesario
        $authors = Author::all();
        $genres = Genre::all();

        // Pasar los datos a la vista
        return view('layouts.shop.editionsShop', compact('editions', 'authors', 'genres'));
    }


    public function showPurchaseForm($id)
    {
        $edition = Edition::with(['book', 'book.authors', 'book.genres'])->findOrFail($id);

        return view('layouts.shop.purchase', compact('edition'));
    }

    public function processPurchase(Request $request, $id)
    {
        $edition = Edition::findOrFail($id);

        // Lógica para procesar el pago con Stripe
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        try {
            // Crear el PaymentIntent utilizando el Token
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $edition->price * 100, // Precio en centavos
                'currency' => 'eur',
                'payment_method' => $request->stripeToken,
                'confirmation_method' => 'manual',
                'confirm' => true,
            ]);

            // Guardar la tarjeta en la base de datos
            $user = Auth::user();
            $this->saveCreditCard($request, $user->id);

            // Crear la factura
            $this->createInvoice($user->id, $edition->id, $paymentIntent->id, $edition->price);

            return response()->json(['success' => true, 'paymentIntentId' => $paymentIntent->id, 'clientSecret' => $paymentIntent->client_secret]);
        } catch (\Stripe\Exception\CardException $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }



    private function saveCreditCard($request, $userId)
    {
        $cardLastFourDigits = $request->payment_method['card']['last4'] ?? null;

        if ($cardLastFourDigits) {
            $expirationDate = Carbon::createFromFormat(
                'm/d',
                $request->payment_method['card']['exp_month'] . '/' . substr($request->payment_method['card']['exp_year'], -2)
            )->format('Y-m-d');

            CreditCard::create([
                'user_id' => $userId,
                'card_number' => $cardLastFourDigits,
                'card_holder_name' => $request->payment_method['billing_details']['name'] ?? 'Unknown', // Ajusta según tus necesidades
                'expiration_date' => $expirationDate,
                'country_id' => 1, // Ajusta el ID del país según tu lógica
            ]);
        } else {
            // Manejar el caso en que last4 no está presente en la respuesta de Stripe
            // Puedes registrar una entrada de registro, lanzar una excepción, o realizar otras acciones según tus necesidades
            Log::warning('El valor last4 no está presente en la respuesta de Stripe al intentar guardar la tarjeta.');
        }
    }



    private function createInvoice($userId, $editionId, $paymentIntentId, $amount)
    {
        // Lógica para crear una factura en la base de datos (Invoice)
        $invoiceCode = uniqid(); // Ajusta esto según tu lógica

        $expirationDate = Carbon::createFromFormat('m/d', $paymentIntentId['card']['exp_month'] . '/' . substr($paymentIntentId['card']['exp_year'], -2))->format('Y-m-d');


        // Buscar la tarjeta basándote en más información
        $lastFourDigits = substr($paymentIntentId, -4);
        $card = CreditCard::where('user_id', $userId)
            ->where('card_number_last_four', $lastFourDigits)
            ->where('card_holder_name', $paymentIntentId['billing_details']['name'])
            ->where('expiration_date', $paymentIntentId['card']['exp_month'] . '/' . substr($paymentIntentId['card']['exp_year'], -2))
            ->first();

        // Asegurarte de que se encontró la tarjeta
        if ($card) {
            Invoice::create([
                'invoice_code' => $invoiceCode,
                'amount' => $amount,
                'user_id' => $userId,
                'edition_id' => $editionId,
                'card_id' => $card->id,
            ]);
        } else {
            // Crear una nueva tarjeta si no se encuentra una coincidencia
            $newCard = CreditCard::create([
                'user_id' => $userId,
                'card_number_last_four' => $lastFourDigits,
                'card_holder_name' => $paymentIntentId['billing_details']['name'],
                'expiration_date' => $paymentIntentId['card']['exp_month'] . '/' . substr($paymentIntentId['card']['exp_year'], -2),
            ]);

            Invoice::create([
                'invoice_code' => $invoiceCode,
                'amount' => $amount,
                'user_id' => $userId,
                'edition_id' => $editionId,
                'card_id' => $newCard->id,
            ]);
        }
    }
}
