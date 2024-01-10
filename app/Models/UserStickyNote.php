<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserStickyNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'user_id',
    ];

    /**
     * Get the user that owns the sticky note.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
