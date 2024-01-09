<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditionBook extends Model
{
    use HasFactory;

    protected $table = 'edition_books';

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

    protected $casts = [
        'self_published' => 'boolean',
        'visible' => 'boolean',
        'deleted' => 'boolean',
    ];

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'book_authors', 'book_id', 'author_id');
    }
}
