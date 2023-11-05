<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookGenre extends Model
{
    use HasFactory;

    protected $table = 'books_genres';
    protected $fillable = ['book_id', 'genre_id'];

    // No es necesario definir relaciones "belongsTo" en este caso, ya que esta tabla solo contiene las claves foráneas.

}
