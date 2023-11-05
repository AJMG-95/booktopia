<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAuthor extends Model
{
    use HasFactory;

    protected $table = 'users_authors';
    protected $fillable = ['user_id', 'author_id'];

    // No es necesario definir relaciones "belongsTo" en este caso, ya que esta tabla solo contiene las claves foráneas.

}
