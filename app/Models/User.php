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
        'profile_img',
        'rol_id',
        'strikes',
        'blocked',
        'deleted',
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
        'deleted' => 'boolean',
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

    public function hasRole($role)
    {
        return $this->role && $this->role->rol_name === $role;
    }

    public function hasAnyRole($roles)
    {
        return $this->role && in_array($this->role->rol_name, $roles);
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



    /**
     * Override the delete method to mark the user as "deleted" and clear sensitive data.
     *
     * @return bool|null
     * @throws \Exception
     */
    public function delete()
    {
        // Clear sensitive data
        $this->nickname = null;
        $this->email = null;
        $this->password = null;
        $this->birth_date = null;
        $this->country_id = null;
        $this->profile_img = null;
        $this->rol_id = null;
        $this->strikes = null;
        $this->blocked = false;

        // Mark the user as "deleted"
        $this->deleted = true;

        // Save the changes
        $this->save();

        return true;
    }


    /**
     * Muestra todos los usuarios.
     *
     * @return \Illuminate\View\View
     */
    public function showAllUsers()
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }

    /**
     * Muestra todos los subadmins.
     *
     * @return \Illuminate\View\View
     */
    public function showAllSubadmins()
    {
        $subadmins = User::where('rol_id', 2)->get();
        return view('subadmin.index', compact('subadmins'));
    }
}
