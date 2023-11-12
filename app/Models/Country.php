<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_name',
        'iso_code',
        'flag_url',
    ];

    /**
     * Get the authors associated with the country.
     */
    public function authors()
    {
        return $this->hasMany(Author::class);
    }

    /**
     * Get the users associated with the country.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the credit cards associated with the country.
     */
    public function creditCards()
    {
        return $this->hasMany(CreditCard::class);
    }
}
