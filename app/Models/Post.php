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
     * Get the user who made the post.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
