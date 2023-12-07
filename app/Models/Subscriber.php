<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'end_at',
        'is_active',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array
     */
    protected $casts = [
        'end_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Obtener el usuario que es dueño de la suscripción.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
