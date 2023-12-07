<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $fillable = [
        'genre',
        'description',
        'img_url',
    ];

    /**
     * Obtener los libros asociados con el género.
     */
    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_genres');
    }
}
