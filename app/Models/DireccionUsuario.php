<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DireccionUsuario extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla asociada.
     *
     * @var string
     */
    protected $table = 'direccionesusuarios';

    /**
     * Clave primaria personalizada.
     *
     * @var string
     */
    protected $primaryKey = 'direccionesUsuariosID';

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
        'usuarioID',
        'cpDireccion',
        'municipioDireccion',
        'estadoID',
        'direccion',
        'activoDireccion',
        'estadoDireccion',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'activoDireccion' => 'boolean',
        'estadoDireccion' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relación con el modelo Usuario.
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuarioID', 'usuarioID');
    }

    /**
     * Relación con el modelo Estado.
     */
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estadoID', 'estadoID');
    }
}
