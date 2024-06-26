<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
    ];

    /**
     * Get the user that owns the favorite.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the book that is favorited.
     */
    public function book()
    {
        return $this->belongsTo(EditionBook::class);
    }

    public function editionBook()
    {
        return $this->belongsTo(EditionBook::class, 'book_id');
    }

}
