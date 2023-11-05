<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookEdition extends Model
{
    use HasFactory;

    protected $table = 'book_editions';
    protected $fillable = [
        'isbn',
        'title',
        'description',
        'editorial',
        'publication_date',
        'price',
        'url',
        'book_id',
        'language_id',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
