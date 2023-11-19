<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'surnames',
        'birth_at',
        'country_id',
        'biography',
        'photo'
    ];

    /**
     * Get the country that the author belongs to.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the books written by the author.
     */
    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_authors');
    }


}
