<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'body',
    ];

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(EditionBook::class);
    }

    public function likes()
    {
        return $this->hasMany(CommentLdr::class, 'comment_id')->where('likes', true);
    }

     // Método para obtener el número de "likes"
     public function getLikes()
     {
         return $this->likes()->count();
     }

    public function dislikes()
    {
        return $this->hasMany(CommentLdr::class, 'comment_id')->where('dislikes', true);
    }

    public function getDislikes()
    {
        return $this->dislikes()->count();
    }

    public function reports()
    {
        return $this->hasMany(CommentLdr::class, 'comment_id')->where('reports', true);
    }

    public function getReports()
    {
        return $this->reports()->count();
    }

}
