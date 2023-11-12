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
     * Get the user who owns the library entry.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the edition associated with the library entry.
     */
    public function edition()
    {
        return $this->belongsTo(Edition::class);
    }
}
