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
     * Get the edition books written in this country's language.
     */
    public function editionBooks()
    {
        return $this->hasManyThrough(EditionBook::class, Language::class);
    }
}
