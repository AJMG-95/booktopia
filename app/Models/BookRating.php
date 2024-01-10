<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookRating extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'rating',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(EditionBook::class);
    }

    /**
     * Calcula la valoración media para el libro asociado.
     *
     * @return float|null
     */
    public function calculateAverageRating()
    {
        $averageRating = $this->book->ratings()->avg('rating');

        return $averageRating;
    }
}
