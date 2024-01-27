<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use App\Models\UserPost;

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
        return $this->belongsTo(Country::class, 'country_id');
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


    /**
     * Verificar si el usuario tiene 18 o más años
     * @return bool
     */
    public function isAdult()
    {
        return $this->birth_date->age >= 18;
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

/*     public function isSubscriber()
    {
        // Verificar si el usuario está en la tabla user_subscribers y si la suscripción está activa y no ha caducado
        return $this->subscriber()->exists() && $this->subscriber->is_active && $this->subscriber->end_at >= Carbon::now();
    } */

    public function isSubscriber()
    {
        // Verificar si el usuario está en la tabla user_subscribers y si la suscripción está activa y no ha caducado
        return $this->subscriber()->exists() &&  $this->subscriber->end_at >= Carbon::now();
    }


    // Relación con la tabla user_subscribers
    public function subscriber()
    {
        return $this->hasOne(UserSubscriber::class, 'user_id');
    }

    /*     public function libraries()
    {
        return $this->hasMany(UserLibrary::class, 'user_id');
    } */

    public function comments()
    {
        return $this->hasMany(BookComment::class, 'user_id');
    }

    public function bookRatings()
    {
        return $this->hasMany(BookRating::class);
    }

    public function wishes()
    {
        return $this->hasMany(Wish::class, 'user_id', 'id');
    }

    public function hasPurchasedBook($bookId)
    {
        return $this->payments()->where('book_id', $bookId)->exists();
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function toggleFavorite(EditionBook $book)
    {
        if ($this->isBookInFavorites($book->id)) {
            $this->favorites()->detach($book->id);
        } else {
            $this->favorites()->attach($book->id);
        }
    }

    public function isBookInFavorites($bookId)
    {
        return $this->favorites()->where('book_id', $bookId)->exists();
    }

    public function favorites()
    {
        return $this->belongsToMany(EditionBook::class, 'favorites', 'user_id', 'book_id');
    }


}
