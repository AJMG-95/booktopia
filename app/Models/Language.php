<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{

    use HasFactory;

    protected $fillable = [
        'language',
        'iso_code',
        'flag_url',
    ];

    /**
     * Get the edition books associated with the language.
     */
    public function editionBooks()
    {
        return $this->hasMany(EditionBook::class);
    }
}
