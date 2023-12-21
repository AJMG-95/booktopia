<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StickyNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'user_id',
    ];

    /**
     * Obtener el usuario dueño de la nota adhesiva.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
