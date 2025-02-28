<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuarioEventosController extends Controller
{
    public function eliminarEventos()
    {
        try {
            $registrosEliminados = DB::table('usuarioseventos')
                ->where('usuarioID', 2)
                ->delete();

            return response()->json([
                'success' => true,
                'mensaje' => "Se eliminaron {$registrosEliminados} eventos del usuario",
                'registros_eliminados' => $registrosEliminados
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Error al eliminar los eventos',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}