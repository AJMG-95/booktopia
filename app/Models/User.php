<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nickname',
        'name',
        'surnames',
        'password',
        'birth_date',
        'country_id',
        'email',
        'email_verified_at',
        'rol_id',
        'blocked',
        'strikes',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function creditCards()
    {
        return $this->hasMany(CreditCard::class, 'user_id');
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'users_authors', 'user_id', 'author_id');
    }

    public function books()
    {
        return $this->belongsToMany(Book::class, 'users_books', 'user_id', 'book_id')->withPivot('read');
    }

    public function subscribers()
    {
        return $this->hasMany(Subscriber::class, 'user_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    public function stickyNotes()
    {
        return $this->hasMany(StickyNote::class, 'user_id');
    }

    public function favorites()
    {
        return $this->belongsToMany(Book::class, 'favorites', 'user_id', 'book_id');
    }

    public function wishes()
    {
        return $this->belongsToMany(Book::class, 'wishes', 'user_id', 'book_id');
    }
}
