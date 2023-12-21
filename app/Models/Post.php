<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_title',
        'post_content',
        'likes',
        'dislikes',
        'reports',
        'user_id',
    ];

    /**
     * Obtener el usuario que creó la publicación.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
