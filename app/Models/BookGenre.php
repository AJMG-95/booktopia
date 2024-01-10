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
     * Get the book that owns the genre relationship.
     */
    public function book()
    {
        return $this->belongsTo(EditionBook::class, 'book_id');
    }

    /**
     * Get the genre that owns the book relationship.
     */
    public function genre()
    {
        return $this->belongsTo(Genre::class, 'genre_id');
    }
}
