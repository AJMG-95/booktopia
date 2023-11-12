<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_code',
        'amount',
        'user_id',
        'card_id',
    ];

    /**
     * Get the user associated with the invoice.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the credit card associated with the invoice.
     */
    public function creditCard()
    {
        return $this->belongsTo(CreditCard::class, 'card_id');
    }
}
