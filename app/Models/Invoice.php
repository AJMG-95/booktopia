<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';
    protected $fillable = [
        'invoice_code',
        'amount',
        'user_id',
        'card_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function creditCard()
    {
        return $this->belongsTo(CreditCard::class, 'card_id');
    }

    public function books()
    {
        return $this->belongsToMany(Book::class, 'books_invoices', 'invoice_id', 'book_id');
    }

}
