<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'edition_id',
    ];

    /**
     * Obtener el usuario que marcó la edición como favorita.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtener la edición asociada con la favorita.
     */
    public function edition()
    {
        return $this->belongsTo(Edition::class);
    }
}
