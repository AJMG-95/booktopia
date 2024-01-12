<?php

// app\Models\Wish.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Wish extends Model
{

    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
    ];

    /**
     * Get the user that owns the wish.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the book that the wish belongs to.
     */
    public function book()
    {
        return $this->belongsTo(EditionBook::class);
    }
}
