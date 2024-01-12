<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nickname',
        'name',
        'surnames',
        'password',
        'email',
        'birth_date',
        'country_id',
        'profile_img',
        'email_verified_at',
        'rol_id',
        'strikes',
        'blocked',
        'deleted',
        'biography',
        'isAuthor',
        'user_as_author_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'birth_date' => 'date',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'rol_id');
    }

    /**
     * Verificar si el usuario tiene un rol específico.
     *
     * @param  string  $role
     * @return bool
     */
    public function hasRole($role)
    {
        return $this->role && $this->role->rol_name === $role;
    }

   /**
     * Verificar si el usuario tiene el rol de administrador.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

      /**
     * Verificar si el usuario tiene el rol de subadministrador.
     *
     * @return bool
     */
    public function isSubadmin()
    {
        return $this->hasRole('subadmin');
    }


    public function userAsAuthor()
    {
        return $this->belongsTo(Author::class, 'user_as_author_id');
    }

    public function authoredBooks()
    {
        return $this->hasMany(EditionBook::class, 'author_id');
    }

    public function posts()
    {
        return $this->hasMany(UserPost::class, 'user_id');
    }

    public function stickyNotes()
    {
        return $this->hasMany(UserStickyNote::class, 'user_id');
    }

    public function subscribers()
    {
        return $this->hasMany(UserSubscriber::class, 'user_id');
    }

    public function isSubscriber()
    {
        return $this->subscribers()->where('is_active', true)->exists();
    }

    public function libraries()
    {
        return $this->hasMany(UserLibrary::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(BookComment::class, 'user_id');
    }

    public function ratings()
    {
        return $this->hasMany(BookRating::class, 'user_id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'user_id');
    }

    public function wishes()
    {
        return $this->hasMany(Wish::class, 'user_id', 'id');
    }
}
