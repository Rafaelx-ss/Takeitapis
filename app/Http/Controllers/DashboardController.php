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

    public function Graficadash($IDorganizador)
{
    $meses = [
        1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
        5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
        9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
    ];

    $resultados = Usuario::where('rolUsuario', 'Participante')
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
        ->join('usuarioseventos', 'usuarios.usuarioID', '=', 'usuarioseventos.usuarioID')
        ->whereYear('usuarioseventos.created_at', date('Y')) 
        ->whereMonth('usuarioseventos.created_at', '<=', date('m')) 
        ->selectRaw('MONTH(usuarioseventos.created_at) as mes, COUNT(DISTINCT usuarios.usuarioID) as total')
        ->groupBy('mes')
        ->orderBy('mes')
        ->get()
        ->pluck('total', 'mes') 
        ->toArray();

 
    $data = [];
    for ($i = 1; $i <= date('m'); $i++) {
        $data[] = [
            'name' => $meses[$i],
            'participants' => $resultados[$i] ?? 0 
        ];
    }

    return response()->json($data);
}




}
