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
     * Get the book associated with the book-author relationship.
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Get the author associated with the book-author relationship.
     */
    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
