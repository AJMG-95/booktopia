<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $table = 'favorites';
    protected $fillable = ['user_id', 'book_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function bookEdition()
    {
        return $this->belongsTo(BookEdition::class, 'edition_id');
    }

    /*     public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    } */
}
