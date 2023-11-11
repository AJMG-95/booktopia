<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'end_at',
        'is_active',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'end_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Get the user that owns the subscription.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
