<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookGenre extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'genre_id',
    ];

    /**
     * Get the book associated with the book-genre relationship.
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Get the genre associated with the book-genre relationship.
     */
    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }
}
