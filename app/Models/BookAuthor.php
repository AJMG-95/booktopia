<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookAuthor extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'author_id',
    ];

    /**
     * Toma el libro asociado en la relacion autor-libro
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Toma el autor asociado en la relacion autor-libro
     */
    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
