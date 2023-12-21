<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditionRating extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'edition_id',
        'rating',
    ];

    /**
     * Obtener el usuario que hizo la calificación.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtener la edición asociada con la calificación.
     */
    public function edition()
    {
        return $this->belongsTo(Edition::class);
    }
}
