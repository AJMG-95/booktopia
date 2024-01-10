<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookComment extends Model
{

    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'body',
        'likes',
        'dislikes',
        'reports',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(EditionBook::class, 'book_id');
    }
}
