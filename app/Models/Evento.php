<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla asociada.
     *
     * @var string
     */
    protected $table = 'eventos';

    /**
     * Clave primaria personalizada.
     *
     * @var string
     */
    protected $primaryKey = 'eventoID';

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
        'patrocinadorID',
        'categoriaID',
        'subCategoriaID',
        'nombreEvento',
        'lugarEvento',
        'maximoParticipantesEvento',
        'costoEvento',
        'descripcionEvento',
        'cpEvento',
        'municioEvento',
        'estadoID',
        'direccionEvento',
        'telefonoEvento',
        'fechaEvento',
        'horaEvento',
        'duracionEvento',
        'kitEvento',
        'activoEvento',
        'estadoEvento',
        'createdById',
        'updatedById',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'activoEvento' => 'boolean',
        'estadoEvento' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function usuarios()
    {
        return $this->belongsToMany(Usuario::class, 'usuarioseventos', 'eventoID', 'usuarioID');
    }
}
