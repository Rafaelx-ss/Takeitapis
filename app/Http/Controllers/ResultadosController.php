<?php

namespace App\Http\Controllers;


use App\Models\reporte;
use App\Models\resultados;
use App\Models\Usuario;
use App\Models\Evento;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;

class ResultadosController extends Controller
{
    public function eventosadmin($IDorganizador)
{
    $eventos = Evento::where('estadoEvento', 1)
    ->whereHas('usuarios', function ($query) use ($IDorganizador) {
        $query->where('Eventos.createby', $IDorganizador);
    })
    ->withCount(['usuarios as totalParticipantes' => function ($query) {
        $query->where('rolUsuario', 'Participante');
    }])
    ->get();

    $eventos = $eventos->map(function ($evento) {
        $costos = json_decode($evento->costoEvento, true);
        $precioEntradaGeneral = 0;

        if (is_array($costos)) {
            foreach ($costos as $costo) {
                if ($costo['nombre'] === 'entrada_general') {
                    $precioEntradaGeneral = $costo['precio'];
                    break;
                }
            }
        }

        $evento->totalIngresos = $evento->totalParticipantes * $precioEntradaGeneral;

        return $evento;
    });

    return ResponseHelper::success('cantidadEventos', $eventos);
}

    public function duracionEventostotales($IDorganizador){
        $totalDuracion = Evento::where('createby', $IDorganizador)
            ->sum('duracionEvento');  

        return ResponseHelper::success('HorasTotales', $totalDuracion);
    }

    public function ParticipanteEvento($IDEvento) {
        $Resultado = resultados::where('eventoID', $IDEvento)
            ->join('usuarios', 'usuarios.usuarioID', '=', 'resultados.usuarioID')
            ->leftJoin('direccionesusuarios', 'direccionesusuarios.usuarioID', '=', 'usuarios.usuarioID')
            ->select('resultados.posicion', 'usuarios.nombreUsuario', 'direccionesusuarios.municipioDireccion', 'usuarios.usuarioID')
            ->get()
            ->map(function ($usuario) {
                // Contar los eventos previos (estadoEvento = 0) en los que el usuario está inscrito
                $usuario->eventosPrevios = resultados::join('eventos', 'eventos.eventoID', '=', 'resultados.eventoID')
                    ->where('resultados.usuarioID', $usuario->usuarioID)
                    ->where('eventos.estadoEvento', 0)
                    ->count();
    
                return $usuario;
            });
    
        return ResponseHelper::success('Resultados usuario', $Resultado);
    }
    
    
    
  
}
