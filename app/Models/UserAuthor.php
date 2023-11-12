<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAuthor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'author_id',
    ];

    /**
     * Get the user associated with the author profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the author associated with the UserAuthor.
     */
    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
