<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nickname',
        'name',
        'surnames',
        'email',
        'password',
        'birth_date',
        'country_id',
        'img',
        'rol_id',
        'blocked',
        'strikes',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'birth_date' => 'date',
        'blocked' => 'boolean',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Get the role that owns the user.
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'rol_id');
    }

    /**
     * Get the country that owns the user.
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    /**
     * Determine if the user has admin role.
     */
    public function isAdmin()
    {
        return $this->role->rol_name === 'admin';
    }

    /**
     * Determine if the user has subadmin role.
     */
    public function isSubadmin()
    {
        return $this->role->rol_name === 'subadmin';
    }

    /**
     * Determine if the user is a subscriber based on the end_at field.
     *
     * @return bool
     */
    public function isSubscriber()
    {
        // Check if the user has an active subscription
        return $this->subscriber && $this->subscriber->end_at >= now() && $this->subscriber->is_active;
    }

    /**
     * Get the subscriber record associated with the user.
     */
    public function subscriber()
    {
        return $this->hasOne(Subscriber::class);
    }

    /**
     * Get the sticky notes for the user.
     */
    public function stickyNotes()
    {
        return $this->hasMany(StickyNote::class);
    }


    /**
     * Get the books in the user's library.
     */
    public function library()
    {
        return $this->hasMany(MyLibrary::class);
    }

    /**
     * Get the books wished by the user.
     */
    public function wishedBooks()
    {
        return $this->hasMany(Wish::class);
    }

    /**
     * Get the favorite books of the user.
     */
    public function favoriteBooks()
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Get the author profile if the user is also an author.
     */
    public function authorProfile()
    {
        return $this->hasOne(UserAuthor::class);
    }
}
