<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'edition_id',
        'invoice_id',
    ];

    /**
     * Get the edition associated with the book invoice.
     */
    public function edition()
    {
        return $this->belongsTo(BookEdition::class, 'edition_id');
    }

    /**
     * Get the invoice associated with the book invoice.
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
}
