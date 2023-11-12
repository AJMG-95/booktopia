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
     * Get the user associated with the wish.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the edition associated with the wish.
     */
    public function edition()
    {
        return $this->belongsTo(BookEdition::class);
    }
}
