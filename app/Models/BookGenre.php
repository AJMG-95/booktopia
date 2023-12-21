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
     * Toma el libro asociado a la relacion libro-genero
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Toma el genero asociado a la relacion libro-genero
     */
    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }
}
