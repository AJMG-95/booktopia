<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscriber extends Model
{

    use HasFactory;
    protected $fillable = [
        'user_id',
        'end_at',
        'is_active',
    ];

    protected $dates = [
        'end_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
