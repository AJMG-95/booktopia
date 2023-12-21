<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditionInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'edition_id',
        'invoice_id',
    ];

    /**
     * Toma las ediciones asociadas a la factura
     */
    public function edition()
    {
        return $this->belongsTo(Edition::class, 'edition_id');
    }

    /**
     * Toma la factura asociada a la factura del libro
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
}
