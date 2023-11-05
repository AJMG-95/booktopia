<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $table = 'countries';
    protected $fillable = ['country_name', 'iso_code', 'flag_url'];

    public function users()
    {
        return $this->hasMany(User::class, 'country_id');
    }

    public function creditCards()
    {
        return $this->hasMany(CreditCard::class, 'country_id');
    }

    public function authors()
    {
        return $this->hasMany(Author::class, 'country_id');
    }
}
