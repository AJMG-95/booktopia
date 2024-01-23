<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class EditionBook extends Model
{

    use HasFactory;

    protected $fillable = [
        'isbn',
        'self_published',
        'title',
        'short_description',
        'description',
        'cover',
        'visible',
        'editorial',
        'price',
        'document',
        'language_id',
        'deleted',
        'for_adults',
    ];

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    /**
     * Get the authors associated with the edition book.
     */
    public function authors()
    {
        return $this->belongsToMany(Author::class, 'book_authors', 'book_id', 'author_id');
    }



    /**
     * Toma los generos asociados al libor
     */
    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'book_genres', 'book_id', 'genre_id');
    }

    public function comments()
    {
        return $this->hasMany(BookComment::class);
    }



    public function bookRatings()
    {
        return $this->hasMany(BookRating::class, 'book_id')
            ->where('user_id', Auth::id());
    }

    // Atributo calculado para la valoración media
    public function getAverageRatingAttribute()
    {
        return $this->bookRatings->avg('rating');
    }



    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'book_id');
    }
    /*     public function userLibraries()
    {
        return $this->hasMany(UserLibrary::class);
    } */

    public function wishes()
    {
        return $this->belongsToMany(User::class, 'wishes')->withTimestamps()->withPivot('id')->withTimestamps();
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'book_id');
    }

    public function editionsInPayments()
    {
        return $this->hasMany(Payment::class, 'edition_id');
    }


    public function isBookInFavorites($id)
    {
        return $this->favorites()->where('book_id', $id)->exists();
    }
}
