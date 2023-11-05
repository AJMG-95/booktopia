<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BooksAuthor extends Model
{
    use HasFactory;

    protected $table = 'books_authors';
    protected $fillable = ['author_id', 'book_id'];

    // No es necesario definir relaciones "belongsTo" en este caso, ya que esta tabla solo contiene las claves foráneas.

}
