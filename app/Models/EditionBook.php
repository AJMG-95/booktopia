<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        return $this->belongsToMany(Genre::class, 'book_genres');
    }

    public function comments()
    {
        return $this->hasMany(BookComment::class);
    }

    public function ratings()
    {
        return $this->hasMany(BookRating::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function userLibraries()
    {
        return $this->hasMany(UserLibrary::class);
    }

    public function wishes()
    {
        return $this->belongsToMany(User::class, 'wishes')->withTimestamps()->withPivot('id')->withTimestamps();
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }


    // Agrega cualquier otra relación según sea necesario
}
