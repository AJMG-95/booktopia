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
     * Toma los autores asociados al pais
     */
    public function authors()
    {
        return $this->hasMany(Author::class);
    }

    /**
     * Toma los usuarios asociados al pais
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
