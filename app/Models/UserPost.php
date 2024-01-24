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

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function postLdr()
    {
        return $this->hasOne(UserPostLdr::class, 'post_id');
    }

    public function likes()
    {
        return $this->hasMany(UserPostLdr::class, 'post_id')->where('likes', true);
    }

    public function getLikes()
    {
        return $this->likes()->count();
    }


    public function dislikes()
    {
        return $this->hasMany(UserPostLdr::class, 'post_id')->where('dislikes', true);
    }

    public function getDislikes()
    {
        return $this->dislikes()->count();
    }

    public function reports()
    {
        return $this->hasMany(UserPostLdr::class, 'post_id')->where('reports', true);
    }

    public function getReports()
    {
        return $this->reports()->count();
    }
}
