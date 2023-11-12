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
     * Get the user who marked the edition as favorite.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the edition associated with the favorite.
     */
    public function edition()
    {
        return $this->belongsTo(Edition::class);
    }
}
