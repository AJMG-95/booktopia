<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLibrary extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'read',
    ];

    // Relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con el modelo EditionBook
    public function book()
    {
        return $this->belongsTo(EditionBook::class);
    }
}
