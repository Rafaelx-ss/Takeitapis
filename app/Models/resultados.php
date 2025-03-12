<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class resultados extends Model
{
    use HasFactory;

    protected $table = 'resultados';
    protected $primaryKey = 'resultadoID';
    public $timestamps = true;
    
    protected $fillable = [
        'usuarioID',
        'eventoID',
        'posicion',
        'descripcion',
        'createdbyid'
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuarioID');
    }

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'eventoID');
    }
}
