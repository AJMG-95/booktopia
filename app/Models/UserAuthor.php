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
     * Obtener el usuario asociado con el perfil de autor.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtener el autor asociado con UserAuthor.
     */
    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
