<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'edition_id',
        'edition_name',
        'quantity',
        'amount',
        'currency',
        'user_id',
        'customer_name',
        'customer_email',
        'payment_status',
        'payment_method',
    ];

    // Define relationships if needed
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function book()
    {
        return $this->belongsTo(EditionBook::class, 'edition_id');
    }
}
