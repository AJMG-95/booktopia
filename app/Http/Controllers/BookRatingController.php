<?php

namespace App\Http\Controllers;

use App\Models\BookRating;
use Illuminate\Http\Request;
use App\Models\EditionBook;
use Illuminate\Support\Facades\Auth;

class BookRatingController extends Controller
{
  /**
     * Store a user's rating for a book.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $bookId
     * @return \Illuminate\Http\Response
     */
    public function rateBook(Request $request, $id)
    {

        try {
            $request->validate([
                'rating' => 'required|integer|between:1,5',
            ]);

            $book = EditionBook::findOrFail($id);



            $existingRating = BookRating::where('user_id', Auth::id())
                ->where('book_id', $book->id)
                ->first();

            if ($existingRating) {
                $existingRating->update(['rating' => $request->input('rating')]);
            } else {
                BookRating::create([
                    'user_id' => Auth::id(),
                    'book_id' => $book->id,
                    'rating' => $request->input('rating'),
                ]);
            }

            return redirect()->back()->with('success', '¡Libro valorado con éxito!');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'Ocurrió un error al valorar el libro.');
        }
    }
}
