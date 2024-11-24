<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';

    protected $primaryKey = 'categoriaID';

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    protected $casts = [
        'activoCategoria' => 'boolean',
        'estadoCategoria' => 'boolean',
    ];

    public function creador()
    {
        return $this->belongsTo(User::class, 'createdById');
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'updatedById');
    }
}
