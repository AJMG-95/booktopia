<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id',
        'self_published',
        'original_title',
        'cover',
        'visible',
    ];

    /**
     * Get the author of the book.
     */
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    /**
     * Get the editions of the book.
     */
    public function editions()
    {
        return $this->hasMany(Edition::class);
    }

    /**
     * Get the genres associated with the book.
     */
    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'book_genres');
    }

    /**
     * Custom method to retrieve existing authors and return the view.
     */
    public static function getExistingAuthors()
    {
        $existingAuthors = Author::all();

        return view('bookList', compact('existingAuthors'));
    }
}
