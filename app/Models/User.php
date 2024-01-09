<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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
        'remember_token',
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
        'birth_date' => 'date',
        'email_verified_at' => 'datetime',
        'blocked' => 'boolean',
        'deleted' => 'boolean',
        'isAuthor' => 'boolean',
    ];

    /**
     * La tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Obtener el rol que es dueño del usuario.
     */
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
     * Verificar si el usuario tiene al menos uno de los roles especificados.
     *
     * @param  array  $roles
     * @return bool
     */
    public function hasAnyRole($roles)
    {
        return $this->role && in_array($this->role->rol_name, $roles);
    }

    /**
     * Obtener el país que es dueño del usuario.
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }


    /**
     * Determinar si el usuario tiene el rol de administrador.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role->rol_name === 'admin';
    }

    /**
     * Determinar si el usuario tiene el rol de subadministrador.
     *
     * @return bool
     */
    public function isSubadmin()
    {
        return $this->role->rol_name === 'subadmin';
    }

    /**
     * Determinar si el usuario es un suscriptor basado en el campo `end_at`.
     *
     * @return bool
     */
    public function isSubscriber()
    {
        // Verificar si el usuario tiene una suscripción activa
        return $this->subscriber && $this->subscriber->end_at >= now() && $this->subscriber->is_active;
    }

    /**
     * Obtener el registro de suscriptor asociado con el usuario.
     */
    public function subscriber()
    {
        return $this->hasOne(Subscriber::class);
    }

    /**
     * Obtener las notas adhesivas del usuario.
     */
    public function stickyNotes()
    {
        return $this->hasMany(StickyNote::class);
    }

    /**
     * Obtener los libros en la biblioteca del usuario.
     */
    public function library()
    {
        return $this->hasMany(MyLibrary::class);
    }

    /**
     * Obtener los deseos asociados al usuario.
     */
    public function wishes(): HasMany
    {
        return $this->hasMany(Wish::class);
    }

    /**
     * Obtener los libros favoritos del usuario.
     */
    public function favoriteBooks()
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Obtener el perfil de autor si el usuario también es un autor.
     */
    public function author()
    {
        return $this->belongsTo(Author::class, 'user_as_author_id');
    }

    /**
     * Anular el método de eliminación para marcar al usuario como "eliminado" y borrar los datos sensibles.
     *
     * @return bool|null
     * @throws \Exception
     */
    public function delete()
    {
        // Limpiar datos sensibles
        $this->nickname = null;
        $this->email = null;
        $this->password = null;
        $this->birth_date = null;
        $this->country_id = null;
        $this->profile_img = null;
        $this->rol_id = null;
        $this->strikes = null;
        $this->blocked = false;

        // Marca al usuario como borrado
        $this->deleted = true;

        // Guarda los cambios
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
