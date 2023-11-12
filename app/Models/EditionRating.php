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
     * Get the user who made the rating.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the edition associated with the rating.
     */
    public function edition()
    {
        return $this->belongsTo(Edition::class);
    }
}
