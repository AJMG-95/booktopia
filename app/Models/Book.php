<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'self_published',
        'original_title',
        'cover',
        'visible',
    ];

    /**
     * Toma los autores del libro
     */
    public function authors()
    {
        return $this->belongsToMany(Author::class, 'book_authors');
    }

    /**
     * Toma las ediciones del libro
     */
    public function editions()
    {
        return $this->hasMany(Edition::class);
    }

    /**
     * Toma los generos asociados al libor
     */
    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'book_genres');
    }

    /**
     * Método Custom para obtener autores existetes y devolver la vista bookList
     */
    public static function getExistingAuthors()
    {
        $existingAuthors = Author::all();

        return view('bookList', compact('existingAuthors'));
    }

    /**
     * Calcula la valoración media basandose en las valoraciones de las ediciones
     *
     * @return float
     */
    public function averageRating()
    {
        $editions = $this->editions;

        if ($editions->count() > 0) {
            $totalRating = $editions->pluck('ratings')->flatten()->pluck('rating')->sum();
            return $totalRating / $editions->count();
        }

        return 0;
    }
}
