<?php

// app/Models/Wish.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wish extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'edition_id'];

    // Relación muchos a muchos con restricción única
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación muchos a muchos con restricción única
    public function edition()
    {
        return $this->belongsTo(Edition::class);
    }
}
