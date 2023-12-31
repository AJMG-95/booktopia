<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Edition extends Model
{
    use HasFactory;

    protected $fillable = [
        'isbn',
        'title',
        'description',
        'short_description',
        'cover',
        'editorial',
        'publication_date',
        'price',
        'document',
        'book_id',
        'language_id',
        'deleted',
    ];

    /**
     * Obtener el libro asociado con la edición.
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Obtener el idioma asociado con la edición.
     */
    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    /**
     * Obtener las calificaciones asociadas con la edición.
     */
    public function ratings()
    {
        return $this->hasMany(EditionRating::class);
    }

    /**
     * Obtener los comentarios asociados con la edición.
     */
    public function comments()
    {
        return $this->hasMany(EditionComment::class);
    }

    /**
     * Obtener las facturas asociadas con la edición.
     */
    public function invoices()
    {
        return $this->belongsToMany(Invoice::class, 'edition_invoices');
    }

    /**
     * Obtener los géneros asociados con la edición.
     */
    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'book_genres');
    }

    /**
     * Obtener los usuarios que tienen la edición en su biblioteca.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'my_libraries');
    }

    /**
     * Obtener los usuarios que tienen la edición en su lista de deseos.
     */
    public function wishlistUsers()
    {
        return $this->belongsToMany(User::class, 'wishes');
    }

    /**
     * Obtener los usuarios que tienen la edición como favorita.
     */
    public function favoriteUsers()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    public function wishes()
    {
        return $this->belongsToMany(User::class, 'wishes')->withTimestamps()->withPivot('id')->withTimestamps();
    }

    // Método para verificar si la edición está en la lista de deseos del usuario
    public function isInWishlist($userId)
    {
        return $this->wishes->where('user_id', $userId)->isNotEmpty();
    }

    /**
     * Calculate the average rating for the edition.
     *
     * @return float|null
     */
    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }

    /**
     * Get all comments associated with the edition.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function allComments()
    {
        return $this->comments()->orderBy('created_at', 'desc');
    }


    /*     public function payments(): HasManyThrough
    {
        return $this->hasManyThrough(Payment::class, User::class);
    }
 */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function hasBeenPurchasedByUser($userId)
    {
        return $this->payments()->where('user_id', $userId)->exists();
    }

    public function editionsInPayments()
    {
        return $this->hasMany(Payment::class, 'edition_id');
    }
}
