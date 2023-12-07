<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Los atributos que se pueden asignar masivamente.
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
     * Los atributos que deben ser ocultos para la serialización.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
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
     * Obtener los libros deseados por el usuario.
     */
    public function wishedBooks()
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
    public function authorProfile()
    {
        return $this->hasOne(UserAuthor::class);
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
