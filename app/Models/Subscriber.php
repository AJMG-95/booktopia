<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;

    protected $table = 'subscribers';
    protected $fillable = ['user_id', 'end_at', 'is_active'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
