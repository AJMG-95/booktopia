<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookInvoice extends Model
{
    use HasFactory;

    protected $table = 'books_invoices';
    protected $fillable = ['book_id', 'invoice_id'];


    public function bookEdition()
    {
        return $this->belongsTo(BookEdition::class, 'edition_id');
    }
    // No es necesario definir relaciones "belongsTo" en este caso, ya que esta tabla solo contiene las claves foráneas.

}
