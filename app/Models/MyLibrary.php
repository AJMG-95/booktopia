<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyLibrary extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'edition_id',
        'read',
    ];

    /**
     * Obtener el usuario que posee la entrada en la biblioteca.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtener la edición asociada con la entrada en la biblioteca.
     */
    public function edition()
    {
        return $this->belongsTo(Edition::class);
    }
}
