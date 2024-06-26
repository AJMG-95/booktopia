<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookAuthor extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'book_id',
    ];

    /**
     * Get the author associated with the book author.
     */
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    /**
     * Get the book associated with the book author.
     */
    public function book()
    {
        return $this->belongsTo(EditionBook::class);
    }
}
