<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Edition extends Model
{
    use HasFactory;

    protected $fillable = [
        'isbn',
        'title',
        'description',
        'cover',
        'editorial',
        'publication_date',
        'price',
        'url',
        'book_id',
        'language_id',
    ];

    /**
     * Get the book associated with the edition.
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Get the language associated with the edition.
     */
    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    /**
     * Get the ratings associated with the edition.
     */
    public function ratings()
    {
        return $this->hasMany(EditionRating::class);
    }

    /**
     * Get the comments associated with the edition.
     */
    public function comments()
    {
        return $this->hasMany(EditionComment::class);
    }

    /**
     * Get the invoices associated with the edition.
     */
    public function invoices()
    {
        return $this->belongsToMany(Invoice::class, 'book_invoices');
    }

    /**
     * Get the genres associated with the edition.
     */
    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'book_genres');
    }

    /**
     * Get the users who have the edition in their library.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'my_libraries');
    }

    /**
     * Get the users who have the edition in their wishlist.
     */
    public function wishlistUsers()
    {
        return $this->belongsToMany(User::class, 'wishes');
    }

    /**
     * Get the users who have the edition as their favorite.
     */
    public function favoriteUsers()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }
}
