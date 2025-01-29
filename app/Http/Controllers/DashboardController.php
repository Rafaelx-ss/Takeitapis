<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Evento;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function totalParticipantes($IDorganizador){
        $totalParticipantes = Usuario::where('rolUsuario', 'Participante')
        ->whereHas('eventos', function ($query) use ($IDorganizador) {
            $query->whereIn('usuarioseventos.eventoID', function ($subquery) use ($IDorganizador) {
                $subquery->select('usuarioseventos.eventoID')
                    ->from('usuarioseventos')
                    ->whereIn('usuarioseventos.usuarioID', function ($subSubquery) use ($IDorganizador) {
                        $subSubquery->select('usuarios.usuarioID')
                            ->from('usuarios')
                            ->where('usuarios.usuarioID', $IDorganizador);
                    });
            });
        })
        ->distinct('usuarios.usuarioID') 
        ->count('usuarios.usuarioID');  

    return response()->json(['TotalEventos' => $totalParticipantes]);
    }

    public function cantidadEventosTerminados($usuarioID)
{
    $cantidad = Evento::where('activoEvento', 0)
        ->whereHas('usuarios', function ($query) use ($usuarioID) {
            $query->where('usuarios.usuarioID', $usuarioID);
        })
        ->count();

    return response()->json(['cantidadEventosTerminados' => $cantidad]);
}



}
