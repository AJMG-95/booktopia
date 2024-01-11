<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $fillable = ['genre_name', 'description', 'img_url'];

    /**
     * Obtener todos los libros asociados a este género.
     */
    public function books()
    {
        return $this->belongsToMany(EditionBook::class, 'book_genres', 'genre_id', 'book_id');
    }
}
