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
     * Obtener el país asociado con la tarjeta de crédito.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Obtener el usuario asociado con la tarjeta de crédito.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtener las facturas asociadas con la tarjeta de crédito.
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
