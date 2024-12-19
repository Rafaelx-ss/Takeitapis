<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\App;
use Tymon\JWTAuth\Contracts\JWTSubject;



class Usuario extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * Nombre de la tabla asociada.
     *
     * @var string
     */
    protected $table = 'usuarios';

    /**
     * Clave primaria personalizada.
     *
     * @var string
     */
    protected $primaryKey = 'usuarioID';

    /**
     * Indica si los identificadores son autoincrementales.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * Tipo de clave primaria.
     *
     * @var string
     */
    protected $keyType = 'int';

    /**
     * Indica si el modelo utiliza timestamps.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombreUsuario',
        'usuario',
        'email',
        'password',
        'rolUsuario',
        'telefonoUsuario',
        'fechaNacimientoUsuario',
        'generoUsuario',
        'activoUsuario',
        'estadoUsuario',
    ];

    /**
     * Atributos que se deben ocultar en las respuestas JSON.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'activoUsuario' => 'boolean',
        'estadoUsuario' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    /**
     * Encripta automáticamente la contraseña antes de guardarla.
     *
     * @param string $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * Relación con el modelo DireccionUsuario.
     * Un usuario puede tener muchas direcciones.
     */
    public function direcciones()
    {
        return $this->hasMany(DireccionUsuario::class, 'usuarioID', 'usuarioID');
    }

    public function getAuthPassword()
    {
        return $this->password; // Cambiado de contrasena a password
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    public function eventos()
    {
        return $this->belongsToMany(Evento::class, 'usuarioseventos', 'usuarioID', 'eventoID');
    }
}
