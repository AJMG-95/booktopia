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
     * Obtener el usuario asociado con la factura.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
