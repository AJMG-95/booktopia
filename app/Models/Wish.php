<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wish extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'edition_id',
    ];

    /**
     * Obtener el usuario asociado con el deseo.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtener la edición asociada con el deseo.
     */
    public function edition()
    {
        return $this->belongsTo(Edition::class);
    }
}
