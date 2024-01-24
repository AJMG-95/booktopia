<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentLdr extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'comment_id',
        'likes',
        'dislikes',
        'reports',
    ];

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comment()
    {
        return $this->belongsTo(BookComment::class);
    }
}
