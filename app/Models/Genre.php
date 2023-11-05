<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    protected $table = 'genres';
    protected $fillable = ['genre', 'description', 'image_url'];

    public function books()
    {
        return $this->belongsToMany(Book::class, 'books_genres', 'genre_id', 'book_id');
    }

}
