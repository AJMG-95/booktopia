<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';
    protected $fillable = ['author_id', 'self_published', 'original_title', 'visible'];

    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }

    public function editions()
    {
        return $this->hasMany(BookEdition::class, 'book_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_books', 'book_id', 'user_id')
            ->withPivot('read')
            ->withTimestamps();
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'books_genres', 'book_id', 'genre_id')
            ->withTimestamps();
    }
}
