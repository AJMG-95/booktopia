<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $table = 'authors';
    protected $fillable = ['name', 'surnames', 'birth_at', 'country_id', 'biography'];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function books()
    {
        return $this->belongsToMany(Book::class, 'books_authors', 'author_id', 'book_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_authors', 'author_id', 'user_id');
    }
}
