<?php

// app/Models/ContactUs.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'message', 'status', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
