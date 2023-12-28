<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use App\Models\Payment;
use App\Models\User;
use App\Models\Edition;
use App\Models\Author;
use App\Models\Genre;
use App\Models\Language;

class EditionsBuyedController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Validation of input
            $request->validate([
                'title' => 'nullable|string|max:255',
                'author' => 'nullable|string|max:255',
                'genre' => 'nullable|string|max:255',
                'max_price' => 'nullable|numeric|min:0',
                'min_price' => 'nullable|numeric|min:0',
                'language' => 'nullable|string|max:255',
                'sortBy' => 'nullable|in:asc_price,desc_price,asc_title,desc_title,publication_date',
            ]);

            // Build the main query for editions bought by the user
            $query = Edition::query();

            // Include necessary relationships to avoid N+1 queries
            $query->with(['book.authors', 'book.genres', 'language']);

            // Get the user ID from the authenticated user
            $userId = auth()->user()->id;

            // Filter editions based on user payments
            $query->whereHas('editionInPayments', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            });

            // Apply filters based on URL parameters

            // ... (same as in the previous controller)

            // Order results based on the selected condition
            $orderBy = $request->input('sortBy', 'asc_price');

            switch ($orderBy) {
                // ... (same as in the previous controller)
            }

            // Get the resulting editions with pagination
            $editions = $query->paginate(10); // Or the number of items per page you prefer

            // You can also load additional information if necessary
            $authors = Author::all();
            $genres = Genre::all();
            $languages = Language::all();

            // Pass the data to the view
            return view('layouts.user.editions.buyedEditions', compact('editions', 'authors', 'genres', 'languages', 'request'));
        } catch (ValidationException $validationException) {
            // Handle validation errors
            return redirect()->back()->withErrors($validationException->errors());
        } catch (QueryException $queryException) {
            // Handle database query errors
            Log::error('Query error: ' . $queryException->getMessage());
            return redirect()->back()->with('error', 'An error occurred while processing the request. Please try again.');
        } catch (\Exception $exception) {
            // Handle other uncaught exceptions
            Log::error('Unexpected error: ' . $exception->getMessage());
            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.');
        }
    }
}
