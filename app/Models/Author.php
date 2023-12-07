<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'surnames',
        'birth_at',
        'country_id',
        'biography',
        'photo'
    ];

    /**
     * Toma el pais del autor
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Toma los libros escrtos por el autor
     */
    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_authors');
    }
}
