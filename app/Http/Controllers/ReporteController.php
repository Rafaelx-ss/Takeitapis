<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\reporte;

use App\Helpers\ResponseHelper;

class ReporteController extends Controller
{
    public function reportes($IDorganizador){
        try {
            $totalReportes = Reporte::join('eventos', 'reportes.eventoID', '=', 'eventos.eventoID')
                ->where('eventos.createby', $IDorganizador)
                ->count(); 

            return ResponseHelper::success('Reportestotales', $totalReportes, 200);
        } catch (\Exception $e) {
            return ResponseHelper::error('Error al obtener reportes', 500, $e->getMessage());
        }
    }

    public function reportesEventos($IDorganizador){
        try {
            $reportesEventos = Reporte::select('reportes.*', 'eventos.nombreEvento', 'usuarios.nombreUsuario')
                ->join('eventos', 'reportes.eventoID', '=', 'eventos.eventoID')
                ->join('usuarios', 'reportes.usuarioID', '=', 'usuarios.usuarioID')
                ->where('eventos.createby', $IDorganizador)
                ->get(); 

            return ResponseHelper::success('Reportestotales', $reportesEventos, 200);
        } catch (\Exception $e) {
            return ResponseHelper::error('Error al obtener reportes', 500, $e->getMessage());
        }
    }
}
