<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditionComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'edition_id',
        'body',
        'likes',
        'dislikes',
        'reports',
    ];

    /**
     * Obtener el usuario que realizó el comentario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtener la edición asociada con el comentario.
     */
    public function edition()
    {
        return $this->belongsTo(Edition::class);
    }
}
