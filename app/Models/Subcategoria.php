<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategoria extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla asociada.
     *
     * @var string
     */
    protected $table = 'subcategorias';

    /**
     * Clave primaria personalizada.
     *
     * @var string
     */
    protected $primaryKey = 'subcategoriaID';

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
        'nombreSubcategoria',
        'descripcionSubcategoria',
        'activoSubcategoria',
        'estadoSubcategoria',
        'createdById',
        'updatedById',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'activoSubcategoria' => 'boolean',
        'estadoSubcategoria' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
