<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'card_number',
        'card_holder_name',
        'expiration_date',
        'country_id',
        'user_id',
    ];

    /**
     * Get the country associated with the credit card.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the user associated with the credit card.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the invoices associated with the credit card.
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
