<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'nickname', 'name', 'surnames', 'birth_at', 'country_id', 'biography', 'photo',
    ];

    protected $dates = [
        'birth_at',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function books()
    {
        return $this->belongsToMany(EditionBook::class, 'book_authors', 'author_id', 'book_id')
            ->withTimestamps();
    }

    public function user()
    {
        return $this->hasOne(User::class, 'user_as_author_id');
    }
}
