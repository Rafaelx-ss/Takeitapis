<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla asociada.
     *
     * @var string
     */
    protected $table = 'categorias';

    /**
     * Clave primaria personalizada.
     *
     * @var string
     */
    protected $primaryKey = 'categoriaID';

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
        'categoriaID',
        'nombreCategoria',
        'descripcionCategoria',
        'activoCategoria',
        'estadoCategoria',
        'createdById',
        'updatedById',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'categoriaID' => 'int',
        'activoCategoria' => 'boolean',
        'estadoCategoria' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
