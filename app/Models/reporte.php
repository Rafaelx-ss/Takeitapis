<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    use HasFactory;

    protected $table = 'reportes';
    protected $primaryKey = 'reporteID';
    public $timestamps = false; // Ya tiene 'created_at', pero sin 'updated_at'

    protected $fillable = [
        'eventoID',
        'Tipo',
        'usuarioID',
        'descripcion',
        'detalle',
    ];

    // Relaciones con otras tablas
    public function evento()
    {
        return $this->belongsTo(Evento::class, 'eventoID');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuarioID');
    }
}
