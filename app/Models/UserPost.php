<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_title',
        'post_content',
        'user_id',
    ];

    protected $attributes = [
        'likes' => 0,
        'dislikes' => 0,
        'reports' => 0,
    ];

    /**
     * Obtener el usuario que creó la publicación.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Obtener los usuarios que dieron like a la publicación.
     */
    public function likedBy()
    {
        return $this->belongsToMany(User::class, 'post_likes', 'post_id', 'user_id');
    }

    /**
     * Obtener los usuarios que dieron dislike a la publicación.
     */
    public function dislikedBy()
    {
        return $this->belongsToMany(User::class, 'post_dislikes', 'post_id', 'user_id');
    }

    /**
     * Obtener los usuarios que reportaron la publicación.
     */
    public function reportedBy()
    {
        return $this->belongsToMany(User::class, 'post_reports', 'post_id', 'user_id');
    }

     /**
     * Obtener el total de likes para la publicación.
     */
    public function totalLikes()
    {
        return $this->likedBy()->count();
    }

    /**
     * Obtener el total de dislikes para la publicación.
     */
    public function totalDislikes()
    {
        return $this->dislikedBy()->count();
    }

    /**
     * Obtener el total de reports para la publicación.
     */
    public function totalReports()
    {
        return $this->reportedBy()->count();
    }
}
