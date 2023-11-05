<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookRating extends Model
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

    public function bookEdition()
    {
        return $this->belongsTo(BookEdition::class, 'edition_id');
    }


    /*     public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }
 */
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    public function invoices()
    {
        return $this->belongsToMany(Invoice::class, 'books_invoices', 'book_edition_id', 'invoice_id')
            ->withTimestamps();
    }

    public function ratings()
    {
        return $this->hasMany(BookRating::class, 'book_edition_id');
    }
}
